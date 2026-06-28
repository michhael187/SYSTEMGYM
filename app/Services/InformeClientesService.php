<?php

namespace App\Services;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class InformeClientesService
{
    /**
     * Genera el informe de clientes vigentes con estado activo.
     *
     * @param  array<string, mixed>  $opciones
     * @param  bool  $paraPdf
     * @return array<string, mixed>
     */
    public function generarInformeClientesVigentes(array $opciones = [], bool $paraPdf = false): array
    {
        $fechaReferencia = now()->startOfDay();
        $sortBy = $this->resolverSortBy($opciones['sort_by'] ?? 'fecha_vencimiento', ['cliente', 'membresia', 'fecha_vencimiento']);
        $sortDirection = $this->resolverSortDirection($opciones['sort_direction'] ?? 'asc');

        $baseQuery = Cliente::query()
            ->with('membresiaActual:id,nombre_plan')
            ->select(['id', 'dni', 'nombre', 'apellido', 'telefono', 'estado', 'fecha_vencimiento', 'membresia_actual_id'])
            ->where('estado', true)
            ->where('fecha_vencimiento', '>=', $fechaReferencia);

        $clientesBase = $this->aplicarOrdenClientes($baseQuery, $sortBy, $sortDirection);

        $clientes = $paraPdf
            ? $clientesBase->get()
            : $clientesBase->paginate(50)->onEachSide(1);

        $resumenPorMembresia = Cliente::query()
            ->join('membresias', 'clientes.membresia_actual_id', '=', 'membresias.id')
            ->where('clientes.estado', true)
            ->where('clientes.fecha_vencimiento', '>=', $fechaReferencia)
            ->selectRaw('membresias.nombre_plan as membresia, COUNT(*) as cantidad_clientes')
            ->groupBy('membresias.nombre_plan')
            ->orderByDesc('cantidad_clientes')
            ->get()
            ->map(static function ($fila): array {
                return [
                    'membresia' => $fila->membresia,
                    'cantidad_clientes' => (int) $fila->cantidad_clientes,
                ];
            });

        return [
            'fecha_referencia' => $fechaReferencia,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'total_clientes_vigentes' => $clientes instanceof LengthAwarePaginator ? $clientes->total() : $clientes->count(),
            'resumen_por_membresia' => $resumenPorMembresia,
            'clientes' => $clientes,
        ];
    }

    /**
     * Genera el informe de clientes activos con membresia vencida.
     *
     * @param  array<string, mixed>  $opciones
     * @param  bool  $paraPdf
     * @return array<string, mixed>
     */
    public function generarInformeClientesDeudores(array $opciones = [], bool $paraPdf = false): array
    {
        $fechaReferencia = now()->startOfDay();
        $sortBy = $this->resolverSortBy($opciones['sort_by'] ?? 'fecha_vencimiento', ['cliente', 'membresia', 'fecha_vencimiento', 'dias_atraso']);
        $sortDirection = $this->resolverSortDirection($opciones['sort_direction'] ?? 'asc');

        $baseQuery = Cliente::query()
            ->with('membresiaActual:id,nombre_plan')
            ->select(['id', 'dni', 'nombre', 'apellido', 'telefono', 'estado', 'fecha_vencimiento', 'membresia_actual_id'])
            ->where('estado', true)
            ->where('fecha_vencimiento', '<', $fechaReferencia);

        $clientesBase = $this->aplicarOrdenClientes($baseQuery, $sortBy, $sortDirection);

        $clientes = $paraPdf
            ? $clientesBase->get()
            : $clientesBase->paginate(50)->onEachSide(1);

        $resumenPorMembresia = Cliente::query()
            ->join('membresias', 'clientes.membresia_actual_id', '=', 'membresias.id')
            ->where('clientes.estado', true)
            ->where('clientes.fecha_vencimiento', '<', $fechaReferencia)
            ->selectRaw('membresias.nombre_plan as membresia, COUNT(*) as cantidad_clientes')
            ->groupBy('membresias.nombre_plan')
            ->orderByDesc('cantidad_clientes')
            ->get()
            ->map(static function ($fila): array {
                return [
                    'membresia' => $fila->membresia,
                    'cantidad_clientes' => (int) $fila->cantidad_clientes,
                ];
            });

        return [
            'fecha_referencia' => $fechaReferencia,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'total_clientes_deudores' => $clientes instanceof LengthAwarePaginator ? $clientes->total() : $clientes->count(),
            'resumen_por_membresia' => $resumenPorMembresia,
            'clientes' => $clientes,
        ];
    }

    /**
     * Resuelve el campo de orden valido.
     *
     * @param  mixed  $value
     * @param  array<int, string>  $allowed
     */
    private function resolverSortBy(mixed $value, array $allowed): string
    {
        $sortBy = is_string($value) && in_array($value, $allowed, true)
            ? $value
            : $allowed[0];

        return $sortBy;
    }

    private function resolverSortDirection(mixed $value): string
    {
        return $value === 'desc' ? 'desc' : 'asc';
    }

    /**
     * Aplica el orden solicitado al query base.
     */
    private function aplicarOrdenClientes(Builder $query, string $sortBy, string $sortDirection): Builder
    {
        return match ($sortBy) {
            'cliente' => $query->orderBy('apellido', $sortDirection)->orderBy('nombre', $sortDirection),
            'membresia' => $query
                ->leftJoin('membresias', 'clientes.membresia_actual_id', '=', 'membresias.id')
                ->orderBy('membresias.nombre_plan', $sortDirection)
                ->select('clientes.*'),
            'dias_atraso' => $query
                ->select('clientes.*')
                ->selectRaw('DATEDIFF(?, fecha_vencimiento) as dias_atraso', [$this->formatearFechaReferencia()])
                ->orderBy('dias_atraso', $sortDirection),
            default => $query->orderBy('fecha_vencimiento', $sortDirection),
        };
    }

    private function formatearFechaReferencia(): string
    {
        return Carbon::now()->startOfDay()->toDateString();
    }
}
