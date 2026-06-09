<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\User;
use App\Services\ClienteService;
use App\Services\PagoService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteMasivoSeeder extends Seeder
{
    private const CANTIDAD_CLIENTES = 200;

    public function run(): void
    {
        $clienteService = app(ClienteService::class);
        $pagoService = app(PagoService::class);
        $dniInicial = ((int) Cliente::query()->max('dni')) + 1;
        $membresias = Membresia::query()->orderBy('id')->get()->values();
        $operadores = User::query()
            ->whereIn('rol', RolUsuario::operativosValues())
            ->orderBy('id')
            ->get()
            ->values();

        if ($membresias->isEmpty() || $operadores->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($clienteService, $pagoService, $membresias, $operadores, $dniInicial): void {
            for ($i = 1; $i <= self::CANTIDAD_CLIENTES; $i++) {
                $dni = $dniInicial + ($i - 1);
                $nombre = fake()->firstName();
                $apellido = fake()->lastName();
                $membresia = $membresias[$i % $membresias->count()];
                $operador = $operadores[$i % $operadores->count()];
                $telefono = '38155' . str_pad((string) ($dni % 100000), 5, '0', STR_PAD_LEFT);

                $cliente = $clienteService->crearCliente([
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'telefono' => $telefono,
                    'peso' => fake()->randomFloat(2, 45, 120),
                    'altura' => fake()->randomFloat(2, 1.45, 2.05),
                    'observaciones' => fake()->optional(0.65)->sentence(),
                    'estado' => fake()->boolean(90),
                ]);

                $pagoService->registrarPago([
                    'cliente_id' => $cliente->id,
                    'membresia_id' => $membresia->id,
                    'fecha_pago' => Carbon::now(),
                ], $operador);
            }
        });
    }
}
