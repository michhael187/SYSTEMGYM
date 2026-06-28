<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Clientes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('warning'))
                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 px-5 py-4 text-sm text-yellow-800 shadow-sm">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <form action="{{ route('clientes.index') }}" method="GET" class="grid gap-4 md:grid-cols-[1fr_auto_auto]">
                    <div>
                        <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar cliente</label>
                        <input
                            type="text"
                            name="buscar"
                            id="buscar"
                            value="{{ $busqueda }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Nombre, apellido o DNI"
                        >
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-md bg-slate-900 px-4 py-2 text-white">
                            Buscar
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('clientes.create') }}" class="w-full rounded-md border border-slate-300 px-4 py-2 text-center text-slate-700">
                            Nuevo cliente
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                @if ($clientes->count() === 0)
                    <div class="p-6 text-gray-600">
                        No se encontraron clientes con ese criterio.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Contacto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Membresía</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Vencimiento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <div class="font-semibold text-gray-900">
                                                {{ $cliente->apellido }}, {{ $cliente->nombre }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                DNI: {{ $cliente->dni }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->telefono ?: '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresía' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ optional($cliente->fecha_vencimiento)->format('d/m/Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="{{ $cliente->estado ? 'text-emerald-700' : 'text-gray-500' }}">
                                                {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="text-right">
                                                <a href="{{ route('clientes.edit', $cliente) }}" class="rounded-md bg-slate-900 px-3 py-2 text-white">
                                                    Abrir ficha
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
