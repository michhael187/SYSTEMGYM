<?php

namespace App\Services;

use App\Models\Membresia;
use Carbon\Carbon;
use App\Models\Cliente;

class ClienteService
{

        /**
     * Crea un nuevo cliente con su estado actual inicial.
     */
        public function crearCliente(array $datos): Cliente
    {
        $membresia = Membresia::findOrFail($datos['membresia_actual_id']);

        $fechaUltimoPago = Carbon::parse($datos['fecha_ultimo_pago']);
        $fechaVencimiento = $fechaUltimoPago->copy()->addDays($membresia->duracion_dias);

        return Cliente::create([
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'telefono' => $datos['telefono'],
            'membresia_actual_id' => $datos['membresia_actual_id'],
            'fecha_ultimo_pago' => $datos['fecha_ultimo_pago'],
            'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
            'peso' => $datos['peso'],
            'altura' => $datos['altura'],
            'observaciones' => $datos['observaciones'],
            'estado' => $datos['estado'],
        ]);
    }



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
