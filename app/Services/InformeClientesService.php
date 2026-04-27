<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class InformeClientesService
{
    /**
     * Genera el informe de clientes vigentes con estado activo.
     *
     * @param  array<string, mixed>  $opciones
     * @return array<string, mixed>
     */
    public function generarInformeClientesVigentes(array $opciones = []): array
    {
        $hoy = now()->startOfDay();
        $sortByInput = (string) ($opciones['sort_by'] ?? 'fecha_vencimiento');
        $sortDirectionInput = (string) ($opciones['sort_direction'] ?? 'asc');

        $sortBy = in_array($sortByInput, ['cliente', 'membresia', 'fecha_vencimiento'], true)
            ? $sortByInput
            : 'fecha_vencimiento';
        $sortDirection = in_array($sortDirectionInput, ['asc', 'desc'], true)
            ? $sortDirectionInput
            : 'asc';

        /** @var Collection<int, Cliente> $clientes */
        $clientes = Cliente::with('membresiaActual')
            ->where('estado', true)
            ->whereDate('fecha_vencimiento', '>=', $hoy)
            ->get();

        $clientes = $clientes
            ->sortBy(
                function (Cliente $cliente) use ($sortBy): string|int {
                    return match ($sortBy) {
                        'cliente' => sprintf('%s %s', mb_strtolower((string) $cliente->apellido), mb_strtolower((string) $cliente->nombre)),
                        'membresia' => mb_strtolower((string) ($cliente->membresiaActual?->nombre_plan ?? 'Sin membresia')),
                        default => optional($cliente->fecha_vencimiento)?->timestamp ?? 0,
                    };
                },
                SORT_NATURAL,
                $sortDirection === 'desc'
            )
            ->values();

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
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ];
    }

    /**
     * Genera el informe de clientes activos con membresia vencida.
     *
     * @param  array<string, mixed>  $opciones
     * @return array<string, mixed>
     */
    public function generarInformeClientesDeudores(array $opciones = []): array
    {
        $hoy = now()->startOfDay();
        $sortByInput = (string) ($opciones['sort_by'] ?? 'fecha_vencimiento');
        $sortDirectionInput = (string) ($opciones['sort_direction'] ?? 'asc');

        $sortBy = in_array($sortByInput, ['cliente', 'membresia', 'fecha_vencimiento', 'dias_atraso'], true)
            ? $sortByInput
            : 'fecha_vencimiento';
        $sortDirection = in_array($sortDirectionInput, ['asc', 'desc'], true)
            ? $sortDirectionInput
            : 'asc';

        /** @var Collection<int, Cliente> $clientes */
        $clientes = Cliente::with('membresiaActual')
            ->where('estado', true)
            ->whereNotNull('fecha_vencimiento')
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->get();

        $clientes = $clientes
            ->sortBy(
                function (Cliente $cliente) use ($sortBy, $hoy): string|int {
                    return match ($sortBy) {
                        'cliente' => sprintf('%s %s', mb_strtolower((string) $cliente->apellido), mb_strtolower((string) $cliente->nombre)),
                        'membresia' => mb_strtolower((string) ($cliente->membresiaActual?->nombre_plan ?? 'Sin membresia')),
                        'dias_atraso' => $cliente->fecha_vencimiento?->diffInDays($hoy) ?? 0,
                        default => optional($cliente->fecha_vencimiento)?->timestamp ?? 0,
                    };
                },
                SORT_NATURAL,
                $sortDirection === 'desc'
            )
            ->values();

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
            'total_clientes_deudores' => $clientes->count(),
            'resumen_por_membresia' => $resumenPorMembresia,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ];
    }
}
