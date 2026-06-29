<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\HistorialOperacion;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\User;
use App\Services\VigenciaService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ServidorPruebasSeeder extends Seeder
{
    private const CANTIDAD_CLIENTES = 120;

    public function __construct(private VigenciaService $vigenciaService)
    {
    }

    public function run(): void
    {
        $admin = User::query()->find(1);
        $gerente = User::query()->find(2);

        if (! $admin instanceof User || ! $gerente instanceof User) {
            throw new RuntimeException('Se requieren los usuarios con ID 1 (administrador) e ID 2 (gerente) para ejecutar este seeder.');
        }

        if ($admin->rol !== 'administrador' || $gerente->rol !== 'gerente') {
            throw new RuntimeException('Los usuarios con ID 1 y 2 no tienen los roles esperados para este seeder.');
        }

        DB::transaction(function () use ($admin, $gerente): void {
            $membresias = $this->asegurarMembresias($admin);
            $clientes = $this->crearClientesMasivos($admin, $gerente, $membresias);
            $this->registrarPagosMasivos($admin, $gerente, $clientes, $membresias);
        });
    }

    /**
     * Crea o normaliza las membresias base del sistema.
     *
     * @return array<int, Membresia>
     */
    private function asegurarMembresias(User $admin): array
    {
        $planes = [
            [
                'nombre_plan' => 'Mensual',
                'precio' => 30000.00,
                'duracion_dias' => 30,
            ],
            [
                'nombre_plan' => 'Semanal',
                'precio' => 12000.00,
                'duracion_dias' => 7,
            ],
            [
                'nombre_plan' => 'Diario',
                'precio' => 3000.00,
                'duracion_dias' => 1,
            ],
        ];

        $membresias = [];
        $fechaHora = Carbon::create(2026, 6, 10, 8, 0, 0, 'America/Buenos_Aires');

        foreach ($planes as $plan) {
            $membresia = Membresia::query()->updateOrCreate(
                ['nombre_plan' => $plan['nombre_plan']],
                [
                    'precio' => $plan['precio'],
                    'duracion_dias' => $plan['duracion_dias'],
                    'activo' => true,
                ]
            );

            $accion = $membresia->wasRecentlyCreated ? 'crear' : 'actualizar';
            $descripcion = $membresia->wasRecentlyCreated
                ? sprintf(
                    'El administrador registro la membresia %s con precio $%s y duracion de %d dias.',
                    $membresia->nombre_plan,
                    number_format((float) $membresia->precio, 2, '.', ''),
                    $membresia->duracion_dias
                )
                : sprintf(
                    'El administrador normalizo la membresia %s con precio $%s y duracion de %d dias.',
                    $membresia->nombre_plan,
                    number_format((float) $membresia->precio, 2, '.', ''),
                    $membresia->duracion_dias
                );

            $this->registrarHistorial(
                usuarioId: $admin->id,
                modulo: 'membresias',
                accion: $accion,
                descripcion: $descripcion,
                fechaHora: $fechaHora->copy(),
            );

            $fechaHora->addMinute();
            $membresias[] = $membresia->fresh();
        }

        return $membresias;
    }

    /**
     * Genera una carga masiva de clientes nuevos.
     *
     * @param  array<int, Membresia>  $membresias
     * @return Collection<int, Cliente>
     */
    private function crearClientesMasivos(User $admin, User $gerente, array $membresias): Collection
    {
        $clientes = new Collection();
        $dniBase = ((int) Cliente::query()->max('dni')) + 1;
        $fechaHora = Carbon::create(2026, 6, 12, 8, 0, 0, 'America/Buenos_Aires');

        for ($i = 0; $i < self::CANTIDAD_CLIENTES; $i++) {
            $dni = $dniBase + $i;
            $operador = $i < 30 ? $admin : $gerente;
            $membresia = $membresias[$i % count($membresias)];

            $cliente = Cliente::query()->create([
                'dni' => $dni,
                'nombre' => fake()->firstName(),
                'apellido' => fake()->lastName(),
                'telefono' => $this->generarTelefonoDesdeDni($dni),
                'membresia_actual_id' => null,
                'fecha_ultimo_pago' => null,
                'fecha_vencimiento' => null,
                'peso' => fake()->randomFloat(2, 45, 125),
                'altura' => fake()->randomFloat(2, 1.45, 2.05),
                'observaciones' => fake()->optional(0.55)->sentence(),
                'estado' => true,
            ]);

            $this->registrarHistorial(
                usuarioId: $operador->id,
                modulo: 'clientes',
                accion: 'crear',
                descripcion: sprintf(
                    'El %s registro al cliente %s %s con DNI %d para la membresia %s.',
                    $operador->rol,
                    $cliente->nombre,
                    $cliente->apellido,
                    $cliente->dni,
                    $membresia->nombre_plan
                ),
                fechaHora: $fechaHora->copy(),
            );

            $fechaHora->addMinutes(2);
            $clientes->push($cliente->fresh());
        }

        return $clientes;
    }

    /**
     * Registra pagos en el rango pedido y deja historial de pago y renovacion.
     *
     * @param  array<int, Membresia>  $membresias
     * @param  Collection<int, Cliente>  $clientes
     */
    private function registrarPagosMasivos(User $admin, User $gerente, Collection $clientes, array $membresias): void
    {
        $inicioPagos = Carbon::create(2026, 6, 15, 9, 0, 0, 'America/Buenos_Aires');

        foreach ($clientes as $index => $cliente) {
            $membresia = $membresias[$index % count($membresias)];

            $this->registrarPagoConHistorial(
                cliente: $cliente,
                membresia: $membresia,
                usuario: $index % 3 === 0 ? $admin : $gerente,
                fechaPago: $inicioPagos->copy()->addDays($index % 17),
            );

            if ($index < 60) {
                $this->registrarPagoConHistorial(
                    cliente: $cliente->fresh(),
                    membresia: $membresia,
                    usuario: $index % 2 === 0 ? $gerente : $admin,
                    fechaPago: $inicioPagos->copy()->addDays($index % 17)->addDays(3 + ($index % 5)),
                );
            }

            if ($index < 20) {
                $this->registrarPagoConHistorial(
                    cliente: $cliente->fresh(),
                    membresia: $membresia,
                    usuario: $admin,
                    fechaPago: $inicioPagos->copy()->addDays($index % 17)->addDays(8 + ($index % 4)),
                );
            }
        }
    }

    private function registrarPagoConHistorial(
        Cliente $cliente,
        Membresia $membresia,
        User $usuario,
        Carbon $fechaPago,
    ): void {
        $fechaFin = $this->vigenciaService->calcularNuevaVigencia($cliente, $membresia, $fechaPago);

        $pago = Pago::query()->create([
            'cliente_id' => $cliente->id,
            'usuario_id' => $usuario->id,
            'membresia_id' => $membresia->id,
            'monto' => $membresia->precio,
            'fecha_pago' => $fechaPago,
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ]);

        $cliente->update([
            'membresia_actual_id' => $membresia->id,
            'fecha_ultimo_pago' => $fechaPago,
            'fecha_vencimiento' => $fechaFin->format('Y-m-d'),
            'estado' => true,
        ]);

        $this->registrarHistorial(
            usuarioId: $usuario->id,
            modulo: 'pagos',
            accion: 'registrar',
            descripcion: sprintf(
                'El %s registro un pago de $%s para %s %s sobre la membresia %s con vencimiento %s.',
                $usuario->rol,
                number_format((float) $pago->monto, 2, '.', ''),
                $cliente->nombre,
                $cliente->apellido,
                $membresia->nombre_plan,
                $fechaFin->format('Y-m-d')
            ),
            fechaHora: $fechaPago->copy()->addMinutes(5),
        );

        $this->registrarHistorial(
            usuarioId: $usuario->id,
            modulo: 'clientes',
            accion: 'actualizar',
            descripcion: sprintf(
                'Se actualizo la membresia actual del cliente %s %s con vencimiento %s luego del pago registrado.',
                $cliente->nombre,
                $cliente->apellido,
                $fechaFin->format('Y-m-d')
            ),
            fechaHora: $fechaPago->copy()->addMinutes(7),
        );
    }

    private function registrarHistorial(
        int $usuarioId,
        string $modulo,
        string $accion,
        string $descripcion,
        Carbon $fechaHora,
    ): void {
        HistorialOperacion::query()->create([
            'usuario_id' => $usuarioId,
            'modulo' => $modulo,
            'accion' => $accion,
            'descripcion' => $descripcion,
            'fecha_hora' => $fechaHora,
        ]);
    }

    private function generarTelefonoDesdeDni(int $dni): string
    {
        return '38155' . str_pad((string) ($dni % 100000), 5, '0', STR_PAD_LEFT);
    }
}
