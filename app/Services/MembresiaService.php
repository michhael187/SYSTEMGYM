<?php

namespace App\Services;

use App\Enums\AccionAuditoria;
use App\Models\Membresia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MembresiaService
{
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Crea una nueva membresia activa por defecto.
     */
    public function crearMembresia(array $datos): Membresia
    {
        $membresia = Membresia::create([
            'nombre_plan' => $datos['nombre_plan'],
            'precio' => $datos['precio'],
            'duracion_dias' => $datos['duracion_dias'],
            'activo' => true,
        ]);

        $this->registrarOperacion(
            AccionAuditoria::CREACION,
            $membresia,
            null,
            $membresia->toArray(),
        );

        return $membresia;
    }

    /**
     * Actualiza los datos editables de una membresia existente.
     */
    public function actualizarMembresia(Membresia $membresia, array $datos): Membresia
    {
        $valoresViejos = $membresia->toArray();

        $membresia->update([
            'nombre_plan' => $datos['nombre_plan'],
            'precio' => $datos['precio'],
            'duracion_dias' => $datos['duracion_dias'],
        ]);

        $this->registrarOperacion(
            AccionAuditoria::EDICION,
            $membresia->fresh(),
            $valoresViejos,
            $membresia->fresh()->toArray(),
        );

        return $membresia->fresh();
    }

    /**
     * Realiza la baja logica de una membresia.
     */
    public function darDeBajaMembresia(Membresia $membresia): Membresia
    {
        $valoresViejos = $membresia->toArray();

        $membresia->update([
            'activo' => false,
        ]);

        $this->registrarOperacion(
            AccionAuditoria::ELIMINACION,
            $membresia->fresh(),
            $valoresViejos,
            $membresia->fresh()->toArray(),
        );

        return $membresia->fresh();
    }

    /**
     * Reactiva una membresia dada de baja logicamente.
     */
    public function reactivarMembresia(Membresia $membresia): Membresia
    {
        $valoresViejos = $membresia->toArray();

        $membresia->update([
            'activo' => true,
        ]);

        $this->registrarOperacion(
            AccionAuditoria::EDICION,
            $membresia->fresh(),
            $valoresViejos,
            $membresia->fresh()->toArray(),
        );

        return $membresia->fresh();
    }

    /**
     * @param  array<string, mixed>|null  $valoresViejos
     * @param  array<string, mixed>|null  $valoresNuevos
     */
    private function registrarOperacion(
        AccionAuditoria $accion,
        Membresia $auditable,
        ?array $valoresViejos,
        ?array $valoresNuevos,
    ): void {
        $operador = Auth::user();

        if (! $operador instanceof User) {
            return;
        }

        $this->auditoriaService->registrar(
            operador: $operador,
            accion: $accion,
            modulo: 'membresias',
            auditable: $auditable,
            valoresViejos: $valoresViejos,
            valoresNuevos: $valoresNuevos,
            direccionIp: request()->ip(),
        );
    }
}
