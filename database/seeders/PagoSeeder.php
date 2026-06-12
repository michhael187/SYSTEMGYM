<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\User;
use App\Services\PagoService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(PagoService::class);

        $clientes = Cliente::orderBy('id')->get()->values();
        $membresias = Membresia::orderBy('id')->get()->values();
        $operadores = User::whereIn('rol', RolUsuario::operativosValues())
            ->orderBy('id')
            ->get()
            ->values();

        if ($clientes->isEmpty() || $membresias->isEmpty() || $operadores->isEmpty()) {
            return;
        }

        $fechaBase = Carbon::now()->subDays(90);

        foreach ($clientes as $index => $cliente) {
            $membresia = $membresias[$index % $membresias->count()];
            $operador = $operadores[$index % $operadores->count()];
            $fechaPago = $fechaBase->copy()->addDays($index * 2);

            $service->registrarPago([
                'cliente_id' => $cliente->id,
                'membresia_id' => $membresia->id,
                'fecha_pago' => $fechaPago,
            ], $operador);

            if ($index < 8) {
                $fechaSegundoPago = $fechaPago->copy()->addDays($this->diasParaRenovacion($membresia->duracion_dias));
                $operadorSegundo = $operadores[($index + 1) % $operadores->count()];

                $service->registrarPago([
                    'cliente_id' => $cliente->id,
                    'membresia_id' => $membresia->id,
                    'fecha_pago' => $fechaSegundoPago,
                ], $operadorSegundo);
            }

            if ($index < 4) {
                $fechaTercerPago = $fechaPago
                    ->copy()
                    ->addDays($this->diasParaRenovacion($membresia->duracion_dias) * 2);
                $operadorTercero = $operadores[($index + 2) % $operadores->count()];

                $service->registrarPago([
                    'cliente_id' => $cliente->id,
                    'membresia_id' => $membresia->id,
                    'fecha_pago' => $fechaTercerPago,
                ], $operadorTercero);
            }
        }
    }

    private function diasParaRenovacion(int $duracionDias): int
    {
        return max(1, $duracionDias - 1);
    }
}
