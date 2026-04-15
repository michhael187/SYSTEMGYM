<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    /**
     * Actualiza los datos editables de un cliente existente.
     */
    public function actualizarCliente(Cliente $cliente, array $datos): Cliente
    {
        $cliente->update([
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'telefono' => $datos['telefono'],
            'membresia_actual_id' => $datos['membresia_actual_id'],
            'fecha_ultimo_pago' => $datos['fecha_ultimo_pago'],
            'fecha_vencimiento' => $datos['fecha_vencimiento'],
            'peso' => $datos['peso'],
            'altura' => $datos['altura'],
            'observaciones' => $datos['observaciones'],
            'estado' => $datos['estado'],
        ]);

        return $cliente->fresh();
    }
}
