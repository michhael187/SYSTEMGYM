<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion de Usuarios
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <form action="{{ route('usuarios.index') }}" method="GET" class="grid gap-4 md:grid-cols-[1fr_auto_auto]">
                    <div>
                        <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar usuario</label>
                        <input
                            type="text"
                            name="buscar"
                            id="buscar"
                            value="{{ $busqueda }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Nombre, apellido, email o DNI"
                        >
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-md bg-slate-900 px-4 py-2 text-white">
                            Buscar
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('usuarios.create') }}" class="w-full rounded-md border border-slate-300 px-4 py-2 text-center text-slate-700">
                            Nuevo usuario
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                @if ($usuarios->count() === 0)
                    <div class="p-6 text-gray-600">
                        No se encontraron usuarios con ese criterio.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $usuario->apellido }}, {{ $usuario->nombre }}<br>
                                            <span class="text-xs text-gray-500">DNI: {{ $usuario->dni }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($usuario->rol) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $usuario->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="{{ $usuario->estado ? 'text-emerald-700' : 'text-red-700' }}">
                                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="rounded-md bg-slate-900 px-3 py-2 text-white">
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
            <div>
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
