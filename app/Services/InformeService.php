<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class InformeService
{
    /**
     * Resuelve el rango de fechas aplicando valores por defecto.
     *
     * @param  array<string, mixed>  $filtros
     * @return array{0: Carbon, 1: Carbon}
     */
    public function resolverRangoFechas(array $filtros): array
    {
        $fechaDesde = isset($filtros['fecha_desde']) && $filtros['fecha_desde'] !== null
            ? Carbon::parse($filtros['fecha_desde'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $fechaHasta = isset($filtros['fecha_hasta']) && $filtros['fecha_hasta'] !== null
            ? Carbon::parse($filtros['fecha_hasta'])->endOfDay()
            : now()->endOfMonth()->endOfDay();

        return [$fechaDesde, $fechaHasta];
    }

    /**
     * Genera el informe financiero en un rango de fechas.
     *
     * @param  array<string, mixed>  $filtros
     * @return array<string, mixed>
     */
    public function generarInformeFinanciero(array $filtros): array
    {
        [$fechaDesde, $fechaHasta] = $this->resolverRangoFechas($filtros);

        /** @var Collection<int, Pago> $pagos */
        $pagos = Pago::with(['cliente', 'membresia', 'usuario'])
            ->whereBetween('fecha_pago', [$fechaDesde, $fechaHasta])
            ->orderByDesc('fecha_pago')
            ->get();

        $totalRecaudado = (float) $pagos->sum('monto');
        $cantidadPagos = $pagos->count();
        $promedioPorPago = $cantidadPagos > 0
            ? $totalRecaudado / $cantidadPagos
            : 0.0;

        /** @var SupportCollection<int, array{membresia: string, cantidad_pagos: int, monto_total: float}> $resumenPorMembresia */
        $resumenPorMembresia = $pagos
            ->groupBy(fn (Pago $pago) => $pago->membresia?->nombre_plan ?? 'Sin membresia')
            ->map(function (Collection $grupo, string $nombreMembresia): array {
                return [
                    'membresia' => $nombreMembresia,
                    'cantidad_pagos' => $grupo->count(),
                    'monto_total' => (float) $grupo->sum('monto'),
                ];
            })
            ->sortByDesc('monto_total')
            ->values();

        return [
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'pagos' => $pagos,
            'total_recaudado' => $totalRecaudado,
            'cantidad_pagos' => $cantidadPagos,
            'promedio_por_pago' => $promedioPorPago,
            'resumen_por_membresia' => $resumenPorMembresia,
        ];
    }

    /**
     * Genera el informe de clientes vigentes con estado activo.
     *
     * @return array<string, mixed>
     */
    public function generarInformeClientesVigentes(): array
    {
        $hoy = now()->startOfDay();

        /** @var Collection<int, Cliente> $clientes */
        $clientes = Cliente::with('membresiaActual')
            ->where('estado', true)
            ->whereDate('fecha_vencimiento', '>=', $hoy)
            ->orderBy('fecha_vencimiento')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        /** @var SupportCollection<int, array{membresia: string, cantidad_clientes: int}> $resumenPorMembresia */
        $resumenPorMembresia = $clientes
            ->groupBy(fn (Cliente $cliente) => $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia')
            ->map(function (Collection $grupo, string $nombreMembresia): array {
                return [
                    'membresia' => $nombreMembresia,
                    'cantidad_clientes' => $grupo->count(),
                ];
            })
            ->sortByDesc('cantidad_clientes')
            ->values();

        return [
            'fecha_referencia' => $hoy,
            'clientes' => $clientes,
            'total_clientes_vigentes' => $clientes->count(),
            'resumen_por_membresia' => $resumenPorMembresia,
        ];
    }
}
