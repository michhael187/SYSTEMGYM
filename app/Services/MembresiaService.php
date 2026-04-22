<?php

namespace App\Services;

use App\Models\Membresia;

class MembresiaService
{
    /**
     * Crea una nueva membresia activa por defecto.
     */
    public function crearMembresia(array $datos): Membresia
    {
        return Membresia::create([
            'nombre_plan' => $datos['nombre_plan'],
            'precio' => $datos['precio'],
            'duracion_dias' => $datos['duracion_dias'],
            'activo' => true,
        ]);
    }

    /**
     * Actualiza los datos editables de una membresia existente.
     */
    public function actualizarMembresia(Membresia $membresia, array $datos): Membresia
    {
        $membresia->update([
            'nombre_plan' => $datos['nombre_plan'],
            'precio' => $datos['precio'],
            'duracion_dias' => $datos['duracion_dias'],
        ]);

        return $membresia->fresh();
    }

    /**
     * Realiza la baja logica de una membresia.
     */
    public function darDeBajaMembresia(Membresia $membresia): Membresia
    {
        $membresia->update([
            'activo' => false,
        ]);

        return $membresia->fresh();
    }

    /**
     * Reactiva una membresia dada de baja logicamente.
     */
    public function reactivarMembresia(Membresia $membresia): Membresia
    {
        $membresia->update([
            'activo' => true,
        ]);

        return $membresia->fresh();
    }

}
