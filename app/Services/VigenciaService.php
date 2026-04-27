<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Membresia;
use Carbon\Carbon;

class VigenciaService
{
    /**
     * Calcula el vencimiento inicial al crear un cliente.
     */
    public function calcularVencimientoInicial(Membresia $membresia, Carbon $fechaInicio): Carbon
    {
        return $fechaInicio->copy()->addDays($membresia->duracion_dias);
    }

    /**
     * Calcula la nueva vigencia al registrar un pago.
     */
    public function calcularNuevaVigencia(Cliente $cliente, Membresia $membresia, Carbon $fechaPago): Carbon
    {
        $fechaBase = $fechaPago->copy();

        if (
            $cliente->fecha_vencimiento &&
            Carbon::parse($cliente->fecha_vencimiento)->greaterThanOrEqualTo($fechaPago->copy()->startOfDay())
        ) {
            $fechaBase = Carbon::parse($cliente->fecha_vencimiento);
        }

        return $fechaBase->copy()->addDays($membresia->duracion_dias);
    }
}
