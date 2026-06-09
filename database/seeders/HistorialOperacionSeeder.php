<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Models\Cliente;
use App\Models\HistorialOperacion;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HistorialOperacionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('rol', RolUsuario::ADMINISTRADOR->value)->orderBy('id')->first();
        $operadores = User::whereIn('rol', RolUsuario::operativosValues())
            ->orderBy('id')
            ->get()
            ->values();

        if (! $admin || $operadores->isEmpty()) {
            return;
        }

        $timestamp = Carbon::now()->subDays(130);

        $membresias = Membresia::orderBy('id')->get();

        foreach ($membresias as $membresia) {
            $timestamp->addMinute();

            $this->registrarHistorial(
                $admin->id,
                'membresias',
                'crear',
                sprintf(
                    'Se creo la membresia %s por un valor de $%s y duracion de %d dias.',
                    $membresia->nombre_plan,
                    number_format((float) $membresia->precio, 2, '.', ''),
                    $membresia->duracion_dias
                ),
                $timestamp
            );
        }

        $timestamp->addDay();

        $usuarios = User::orderBy('id')->get();

        foreach ($usuarios as $usuario) {
            $timestamp->addMinute();

            $this->registrarHistorial(
                $admin->id,
                'usuarios',
                'crear',
                sprintf(
                    'Se dio de alta al usuario %s %s con rol %s.',
                    $usuario->nombre,
                    $usuario->apellido ?? '',
                    $usuario->rol
                ),
                $timestamp
            );
        }

        $timestamp->addDay();

        $clientes = Cliente::orderBy('id')->get();

        foreach ($clientes as $index => $cliente) {
            $registrador = $operadores[$index % $operadores->count()];
            $timestamp->addMinute();

            $this->registrarHistorial(
                $registrador->id,
                'clientes',
                'registrar',
                sprintf(
                    'Se registro al cliente %s %s con DNI %d.',
                    $cliente->nombre,
                    $cliente->apellido,
                    $cliente->dni
                ),
                $timestamp
            );
        }

        $pagos = Pago::with(['cliente', 'membresia'])->orderBy('fecha_pago')->orderBy('id')->get();

        foreach ($pagos as $pago) {
            $timestamp = Carbon::parse($pago->fecha_pago)->copy()->addMinutes(5);

            $this->registrarHistorial(
                $pago->usuario_id,
                'pagos',
                'registrar',
                sprintf(
                    'Se registro un pago de $%s para %s %s sobre la membresia %s con vencimiento %s.',
                    number_format((float) $pago->monto, 2, '.', ''),
                    $pago->cliente?->nombre ?? 'Cliente',
                    $pago->cliente?->apellido ?? '',
                    $pago->membresia?->nombre_plan ?? 'sin plan',
                    $pago->fecha_fin?->format('Y-m-d') ?? 'sin fecha'
                ),
                $timestamp
            );
        }
    }

    private function registrarHistorial(
        int $usuarioId,
        string $modulo,
        string $accion,
        string $descripcion,
        Carbon $fechaHora
    ): void {
        HistorialOperacion::create([
            'usuario_id' => $usuarioId,
            'modulo' => $modulo,
            'accion' => $accion,
            'descripcion' => $descripcion,
            'fecha_hora' => $fechaHora,
        ]);
    }
}
