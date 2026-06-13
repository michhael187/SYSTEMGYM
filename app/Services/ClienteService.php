<?php

namespace App\Services;

use App\Enums\AccionAuditoria;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClienteService
{
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Crea un nuevo cliente con su estado actual inicial.
     */
    public function crearCliente(array $datos): Cliente
    {
        $cliente = Cliente::create([
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'telefono' => $datos['telefono'],
            'membresia_actual_id' => null,
            'fecha_ultimo_pago' => null,
            'fecha_vencimiento' => null,
            'peso' => $datos['peso'],
            'altura' => $datos['altura'],
            'observaciones' => $datos['observaciones'],
            'estado' => $datos['estado'],
        ]);

        $this->registrarOperacion(
            AccionAuditoria::CREACION,
            $cliente,
            null,
            $cliente->toArray(),
        );

        return $cliente;
    }

    /**
     * Actualiza los datos editables de un cliente existente.
     */
    public function actualizarCliente(Cliente $cliente, array $datos): Cliente
    {
        $valoresViejos = $cliente->toArray();

        $cliente->update([
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'telefono' => $datos['telefono'],
            'peso' => $datos['peso'],
            'altura' => $datos['altura'],
            'observaciones' => $datos['observaciones'],
            'estado' => $datos['estado'],
        ]);

        $this->registrarOperacion(
            AccionAuditoria::EDICION,
            $cliente->fresh(),
            $valoresViejos,
            $cliente->fresh()->toArray(),
        );

        return $cliente->fresh();
    }

    /**
     * @param  array<string, mixed>|null  $valoresViejos
     * @param  array<string, mixed>|null  $valoresNuevos
     */
    private function registrarOperacion(
        AccionAuditoria $accion,
        Cliente $auditable,
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
            modulo: 'clientes',
            auditable: $auditable,
            valoresViejos: $valoresViejos,
            valoresNuevos: $valoresNuevos,
            direccionIp: request()->ip(),
        );
    }
}
