<x-app-layout>
    @php
        $nextDirection = static function (string $column, string $currentSortBy, string $currentDirection): string {
            if ($currentSortBy !== $column) {
                return 'asc';
            }

            return $currentDirection === 'asc' ? 'desc' : 'asc';
        };

        $indicator = static function (string $column, string $currentSortBy, string $currentDirection): string {
            if ($currentSortBy !== $column) {
                return '';
            }

            return $currentDirection === 'asc' ? '↑' : '↓';
        };
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Informe de Clientes Vigentes
            </h2>

            <a
                href="{{ route('informes.clientes_vigentes.descargar', ['sort_by' => $sort_by, 'sort_direction' => $sort_direction]) }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:w-auto"
            >
                <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 7H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v10a2 2 0 01-2 2z" />
                </svg>

                <span class="whitespace-nowrap">Descargar PDF</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjetas resumen --}}
            <div class="grid gap-4 md:grid-cols-2">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Fecha de referencia
                    </div>

                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $fecha_referencia->format('d/m/Y') }}
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Clientes vigentes activos
                    </div>

                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $total_clientes_vigentes }}
                    </div>
                </div>
            </div>

            {{-- Resumen por membresía --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Resumen por membresía
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Cantidad de clientes vigentes agrupados según su membresía actual.
                    </p>
                </div>

                @if ($resumen_por_membresia->isEmpty())
                    <div class="p-6 text-gray-600">
                        No hay clientes vigentes para mostrar.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Membresía
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Cantidad de clientes
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($resumen_por_membresia as $fila)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $fila['membresia'] }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $fila['cantidad_clientes'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Detalle de clientes vigentes --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Detalle de clientes vigentes
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Orden actual:
                        <span class="font-medium text-gray-700">
                            {{ str_replace('_', ' ', $sort_by) }}
                        </span>
                        ({{ $sort_direction === 'asc' ? 'ascendente' : 'descendente' }}).
                    </p>
                </div>

                @if ($clientes->isEmpty())
                    <div class="p-6 text-gray-600">
                        No se encontraron clientes activos con membresía vigente.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'cliente', 'sort_direction' => $nextDirection('cliente', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 transition hover:text-gray-900"
                                            title="Ordenar por cliente"
                                        >
                                            Cliente
                                            <span>{{ $indicator('cliente', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        DNI
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'membresia', 'sort_direction' => $nextDirection('membresia', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 transition hover:text-gray-900"
                                            title="Ordenar por membresía actual"
                                        >
                                            Membresía actual
                                            <span>{{ $indicator('membresia', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'fecha_vencimiento', 'sort_direction' => $nextDirection('fecha_vencimiento', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 transition hover:text-gray-900"
                                            title="Ordenar por fecha de vencimiento"
                                        >
                                            Fecha vencimiento
                                            <span>{{ $indicator('fecha_vencimiento', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Teléfono
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($clientes as $cliente)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->apellido }}, {{ $cliente->nombre }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->dni }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresía' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ optional($cliente->fecha_vencimiento)->format('d/m/Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->telefono ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 px-6 pb-6">
                        {{ $clientes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

