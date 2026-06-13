<?php

namespace App\Services;

use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class InformeFinancieroService
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
     * @param  bool  $paraPdf
     * @return array<string, mixed>
     */
    public function generarInforme(array $filtros, bool $paraPdf = false): array
    {
        [$inicio, $fin] = $this->resolverRangoFechas($filtros);

        $base = Pago::query()
            ->whereBetween('fecha_pago', [$inicio, $fin]);

        $totales = (clone $base)
            ->selectRaw('COUNT(*) as total_pagos, COALESCE(SUM(monto), 0) as total_recaudado')
            ->first();

        $totalPagos = (int) ($totales?->total_pagos ?? 0);
        $totalRecaudado = (float) ($totales?->total_recaudado ?? 0);

        $resumenPorMembresia = (clone $base)
            ->join('membresias', 'pagos.membresia_id', '=', 'membresias.id')
            ->selectRaw('membresias.nombre_plan as membresia, COUNT(*) as cantidad_pagos, COALESCE(SUM(pagos.monto), 0) as monto_total')
            ->groupBy('membresias.nombre_plan')
            ->orderByDesc('monto_total')
            ->get()
            ->map(function ($fila): array {
                return [
                    'membresia' => $fila->membresia,
                    'cantidad_pagos' => (int) $fila->cantidad_pagos,
                    'monto_total' => (float) $fila->monto_total,
                ];
            });

        $detalleQuery = (clone $base)
            ->with([
                'cliente:id,dni,nombre,apellido',
                'membresia:id,nombre_plan',
                'usuario:id,nombre,apellido',
            ])
            ->select(['id', 'cliente_id', 'membresia_id', 'usuario_id', 'monto', 'fecha_pago'])
            ->orderByDesc('fecha_pago');

        $detalle = $paraPdf
            ? $detalleQuery->get()
            : $detalleQuery->paginate(50);

        return [
            'fecha_desde' => $inicio,
            'fecha_hasta' => $fin,
            'total_pagos' => $totalPagos,
            'total_recaudado' => $totalRecaudado,
            'cantidad_pagos' => $totalPagos,
            'promedio_por_pago' => $totalPagos > 0
                ? $totalRecaudado / $totalPagos
                : 0.0,
            'resumen_por_membresia' => $resumenPorMembresia,
            'pagos' => $detalle,
        ];
    }
}
