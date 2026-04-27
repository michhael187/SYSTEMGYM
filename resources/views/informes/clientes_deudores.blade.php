<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Informe de Clientes Deudores
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col gap-4 rounded-lg bg-white p-6 shadow-sm md:flex-row md:items-end md:justify-between">
                <form action="{{ route('informes.clientes_deudores') }}" method="GET" class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700">Ordenar por</label>
                        <select
                            name="sort_by"
                            id="sort_by"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="fecha_vencimiento" {{ $sort_by === 'fecha_vencimiento' ? 'selected' : '' }}>Fecha de vencimiento</option>
                            <option value="cliente" {{ $sort_by === 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="membresia" {{ $sort_by === 'membresia' ? 'selected' : '' }}>Membresia</option>
                            <option value="dias_atraso" {{ $sort_by === 'dias_atraso' ? 'selected' : '' }}>Dias de atraso</option>
                        </select>
                    </div>

                    <div>
                        <label for="sort_direction" class="block text-sm font-medium text-gray-700">Direccion</label>
                        <select
                            name="sort_direction"
                            id="sort_direction"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="asc" {{ $sort_direction === 'asc' ? 'selected' : '' }}>Ascendente</option>
                            <option value="desc" {{ $sort_direction === 'desc' ? 'selected' : '' }}>Descendente</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-white">
                            Aplicar Orden
                        </button>
                    </div>
                </form>

                <a
                    href="{{ route('informes.clientes_deudores.descargar', ['sort_by' => $sort_by, 'sort_direction' => $sort_direction]) }}"
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
                    <div class="text-sm text-gray-500">Clientes activos con membresia vencida</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $total_clientes_deudores }}
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Resumen por membresia</h3>
                </div>

                @if ($resumen_por_membresia->isEmpty())
                    <div class="p-6 text-gray-600">
                        No hay clientes deudores para mostrar.
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
                    <h3 class="text-lg font-semibold text-gray-800">Detalle de clientes deudores</h3>
                </div>

                @if ($clientes->isEmpty())
                    <div class="p-6 text-gray-600">
                        No se encontraron clientes activos con membresia vencida.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">DNI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Membresia actual</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fecha vencimiento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Dias de atraso</th>
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
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->fecha_vencimiento?->diffInDays($fecha_referencia) ?? 0 }}</td>
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
