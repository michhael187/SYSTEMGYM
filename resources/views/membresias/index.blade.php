<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-slate-800">
                Gestión de Planes y Tarifas
            </h2>
            <a href="{{ route('membresias.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nueva Membresía
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <form action="{{ route('membresias.index') }}" method="GET" class="flex flex-col gap-4 md:flex-row md:items-end">
                    
                    <div class="flex-grow">
                        <label for="buscar" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Buscar por nombre</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                            <input type="text" name="buscar" id="buscar" value="{{ $busqueda }}" placeholder="Ej: Todos los dias, Tres veces por semana..." class="block w-full rounded-lg border-slate-300 bg-slate-50 pl-10 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="w-full md:w-48 shrink-0">
                        <label for="estado" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Estado</label>
                        <select name="estado" id="estado" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                            <option value="todas" {{ $estado === 'todas' ? 'selected' : '' }}>Todas las tarifas</option>
                            <option value="activas" {{ $estado === 'activas' ? 'selected' : '' }}>🟢 Solo Activas</option>
                            <option value="inactivas" {{ $estado === 'inactivas' ? 'selected' : '' }}>🔴 Solo Inactivas</option>
                        </select>
                    </div>

                    <div class="shrink-0">
                        <button type="submit" class="w-full rounded-lg bg-slate-800 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 md:w-auto">
                            Aplicar Filtros
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @if ($membresias->count() === 0)
                    <div class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">No hay membresías</h3>
                        <p class="mt-1 text-sm text-slate-500">No se encontraron planes que coincidan con tu búsqueda.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Plan / Membresía</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Precio de Venta</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Duración</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-right font-semibold text-slate-900">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($membresias as $membresia)
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900">
                                            {{ $membresia->nombre_plan }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                            <span class="text-slate-400 mr-1">$</span>{{ number_format((float) $membresia->precio, 2, ',', '.') }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                            {{ $membresia->duracion_dias }} días
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if ($membresia->activo)
                                                <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Activa
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                    Inactiva
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a href="{{ route('membresias.edit', $membresia) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 transition hover:text-blue-800">
                                                Configurar
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if ($membresias->hasPages())
                        <div class="border-t border-slate-200 bg-white px-6 py-4">
                            {{ $membresias->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>