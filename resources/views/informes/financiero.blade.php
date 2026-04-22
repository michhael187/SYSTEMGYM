<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Informe Financiero
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-md">
                    <strong>Se encontraron errores:</strong>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('informes.financiero') }}" method="GET" class="grid gap-4 md:grid-cols-4">
                    <div>
                        <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha desde</label>
                        <input
                            type="date"
                            name="fecha_desde"
                            id="fecha_desde"
                            value="{{ old('fecha_desde', $fecha_desde->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                        @error('fecha_desde')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha hasta</label>
                        <input
                            type="date"
                            name="fecha_hasta"
                            id="fecha_hasta"
                            value="{{ old('fecha_hasta', $fecha_hasta->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                        @error('fecha_hasta')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 text-white">
                            Generar Informe
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a
                            href="{{ route('informes.financiero.descargar', ['fecha_desde' => old('fecha_desde', $fecha_desde->format('Y-m-d')), 'fecha_hasta' => old('fecha_hasta', $fecha_hasta->format('Y-m-d'))]) }}"
                            class="w-full rounded-md bg-emerald-600 px-4 py-2 text-center text-white"
                        >
                            Descargar PDF
                        </a>
                    </div>
                </form>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total recaudado</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        ${{ number_format($total_recaudado, 2, ',', '.') }}
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Cantidad de pagos</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ $cantidad_pagos }}
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Promedio por pago</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">
                        ${{ number_format($promedio_por_pago, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Resumen por membresia</h3>
                </div>

                @if ($resumen_por_membresia->isEmpty())
                    <div class="p-6 text-gray-600">
                        No hay datos para el resumen por membresia en el rango seleccionado.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Membresia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad de pagos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Monto total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($resumen_por_membresia as $filaResumen)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $filaResumen['membresia'] }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $filaResumen['cantidad_pagos'] }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format((float) $filaResumen['monto_total'], 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Detalle de pagos</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Desde {{ $fecha_desde->format('d/m/Y') }} hasta {{ $fecha_hasta->format('d/m/Y') }}.
                    </p>
                </div>

                @if ($pagos->isEmpty())
                    <div class="p-6 text-gray-600">
                        No se encontraron pagos en el rango seleccionado.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Membresia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Monto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Registrado por</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($pagos as $pago)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->cliente->apellido }}, {{ $pago->cliente->nombre }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->membresia->nombre_plan }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format((float) $pago->monto, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->usuario->apellido }}, {{ $pago->usuario->nombre }}</td>
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
