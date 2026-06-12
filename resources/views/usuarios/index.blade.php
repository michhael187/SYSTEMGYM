<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-slate-800">
                Gestión de Usuarios
            </h2>
            <a href="{{ route('usuarios.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <form action="{{ route('usuarios.index') }}" method="GET" class="max-w-md">
                    <label for="buscar" class="block text-sm font-semibold text-slate-700">Buscar usuario</label>
                    <div class="mt-1.5 flex gap-2">
                        <div class="relative w-full shadow-sm rounded-lg">
                            <input
                                type="text"
                                name="buscar"
                                id="buscar"
                                value="{{ $busqueda }}"
                                class="block w-full rounded-lg border-slate-300 bg-slate-50/50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                                placeholder="Nombre, apellido, email o DNI"
                            >
                        </div>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @if ($usuarios->count() === 0)
                    <div class="p-8 text-center text-sm font-medium text-slate-500">
                        No se encontraron usuarios con el criterio indicado.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Personal / Identidad</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Rol Sistema</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Email Informativo</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Estado Acceso</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500 pr-10">Acción</th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($usuarios as $usuario)
                                    <tr class="transition hover:bg-slate-50/70">
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <div class="font-bold text-slate-900">{{ $usuario->apellido }}, {{ $usuario->nombre }}</div>
                                            <div class="text-xs font-medium text-slate-400 mt-0.5">DNI: {{ number_format($usuario->dni, 0, ',', '.') }}</div>
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            @php
                                                $rolLower = strtolower($usuario->rol);
                                                $badgeStyle = match($rolLower) {
                                                    'administrador' => 'bg-blue-600 text-white border-transparent',
                                                    'gerente' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                    default => 'bg-slate-100 text-slate-700 border-slate-200', // Encargado
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wide {{ $badgeStyle }}">
                                                {{ $usuario->rol }}
                                            </span>
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-600">
                                            {{ $usuario->email }}
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold {{ $usuario->estado ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $usuario->estado ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium pr-10">
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                                Gestionar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>