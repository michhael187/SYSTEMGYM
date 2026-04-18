<?php

namespace App\Services;

use App\Models\Pago;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Membresia;
use Carbon\Carbon;

class PagoService
{

    /**
     * Registra un nuevo pago y actualiza el estado actual del cliente.
     */
    public function registrarPago(array $datos, User $usuario): Pago
    {
        $cliente = Cliente::findOrFail($datos['cliente_id']);
        $membresia = Membresia::findOrFail($datos['membresia_id']);

        $fechaPago = Carbon::parse($datos['fecha_pago']);
        $fechaBase = $fechaPago->copy();

        if ($cliente->fecha_vencimiento && Carbon::parse($cliente->fecha_vencimiento)->greaterThanOrEqualTo($fechaPago->copy()->startOfDay())) {
            $fechaBase = Carbon::parse($cliente->fecha_vencimiento);
        }

        $fechaFin = $fechaBase->copy()->addDays($membresia->duracion_dias);

        $pago = Pago::create([
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

        return $pago->fresh();
    }


}
