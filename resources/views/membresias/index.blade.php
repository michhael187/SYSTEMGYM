<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion de Membresias
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <form action="{{ route('membresias.index') }}" method="GET" class="grid gap-4 md:grid-cols-[1fr_220px_auto_auto]">
                    <div>
                        <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar membresia</label>
                        <input
                            type="text"
                            name="buscar"
                            id="buscar"
                            value="{{ $busqueda }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Nombre del plan"
                        >
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="todas" {{ $estado === 'todas' ? 'selected' : '' }}>Todas</option>
                            <option value="activas" {{ $estado === 'activas' ? 'selected' : '' }}>Activas</option>
                            <option value="inactivas" {{ $estado === 'inactivas' ? 'selected' : '' }}>Inactivas</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-md bg-slate-900 px-4 py-2 text-white">
                            Filtrar
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('membresias.create') }}" class="w-full rounded-md border border-slate-300 px-4 py-2 text-center text-slate-700">
                            Nueva membresia
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                @if ($membresias->isEmpty())
                    <div class="p-6 text-gray-600">
                        No se encontraron membresias con ese criterio.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Plan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Duracion</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($membresias as $membresia)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $membresia->nombre_plan }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">${{ number_format((float) $membresia->precio, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $membresia->duracion_dias }} dias</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="{{ $membresia->activo ? 'text-emerald-700' : 'text-red-700' }}">
                                                {{ $membresia->activo ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('membresias.edit', $membresia) }}" class="rounded-md bg-slate-900 px-3 py-2 text-white">
                                                Abrir ficha
                                            </a>
                                        </td>
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
