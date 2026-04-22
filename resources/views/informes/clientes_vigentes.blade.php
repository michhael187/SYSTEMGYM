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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Informe de Clientes Vigentes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a
                    href="{{ route('informes.clientes_vigentes.descargar', ['sort_by' => $sort_by, 'sort_direction' => $sort_direction]) }}"
                    class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white"
                >
                    Descargar PDF
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Fecha de referencia</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $fecha_referencia->format('d/m/Y') }}
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Clientes vigentes activos</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $total_clientes_vigentes }}
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Resumen por membresia</h3>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Membresia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad de clientes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($resumen_por_membresia as $fila)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $fila['membresia'] }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fila['cantidad_clientes'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Detalle de clientes vigentes</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Orden actual:
                        {{ str_replace('_', ' ', $sort_by) }}
                        ({{ $sort_direction === 'asc' ? 'ascendente' : 'descendente' }}).
                    </p>
                </div>

                @if ($clientes->isEmpty())
                    <div class="p-6 text-gray-600">
                        No se encontraron clientes activos con membresia vigente.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'cliente', 'sort_direction' => $nextDirection('cliente', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 hover:text-gray-900"
                                            title="Ordenar por cliente"
                                        >
                                            Cliente
                                            <span>{{ $indicator('cliente', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">DNI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'membresia', 'sort_direction' => $nextDirection('membresia', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 hover:text-gray-900"
                                            title="Ordenar por membresia actual"
                                        >
                                            Membresia actual
                                            <span>{{ $indicator('membresia', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        <a
                                            href="{{ route('informes.clientes_vigentes', ['sort_by' => 'fecha_vencimiento', 'sort_direction' => $nextDirection('fecha_vencimiento', $sort_by, $sort_direction)]) }}"
                                            class="inline-flex items-center gap-1 hover:text-gray-900"
                                            title="Ordenar por fecha de vencimiento"
                                        >
                                            Fecha vencimiento
                                            <span>{{ $indicator('fecha_vencimiento', $sort_by, $sort_direction) }}</span>
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Telefono</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->apellido }}, {{ $cliente->nombre }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->dni }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ optional($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->telefono ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
