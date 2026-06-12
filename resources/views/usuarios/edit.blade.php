<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Modificar Usuario
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-6 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm flex items-center gap-2">
                    <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800 shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-rose-900">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                        Se encontraron errores de validación:
                    </div>
                    <ul class="mt-2 list-disc pl-5 space-y-1 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-900">Datos de la Cuenta</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Modifica los permisos y la información del personal autorizado.</p>
                </div>

                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="p-6 md:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        
                        <div>
                            <label for="dni" class="block text-sm font-semibold text-slate-700">Documento Nacional de Identidad (DNI)</label>
                            <input
                                type="number"
                                id="dni"
                                value="{{ $usuario->dni }}"
                                disabled
                                class="mt-1.5 block w-full rounded-lg border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 shadow-sm cursor-not-allowed focus:ring-0 focus:border-slate-200"
                            >
                        </div>

                        <div>
                            <label for="rol" class="block text-sm font-semibold text-slate-700">Rol asignado <span class="text-rose-500">*</span></label>
                            <select name="rol" id="rol" required class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                                <option value="{{ \App\Enums\RolUsuario::GERENTE->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::GERENTE->value ? 'selected' : '' }}>Gerente</option>
                                <option value="{{ \App\Enums\RolUsuario::ENCARGADO->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::ENCARGADO->value ? 'selected' : '' }}>Encargado</option>
                            </select>
                        </div>

                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-slate-700">Nombre <span class="text-rose-500">*</span></label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                value="{{ old('nombre', $usuario->nombre) }}"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-semibold text-slate-700">Apellido <span class="text-rose-500">*</span></label>
                            <input
                                type="text"
                                name="apellido"
                                id="apellido"
                                value="{{ old('apellido', $usuario->apellido) }}"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-slate-700">Correo Electrónico / Nombre de Usuario <span class="text-rose-500">*</span></label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $user->email ?? $usuario->email) }}"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-5">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            @if ($usuario->estado)
                <div class="overflow-hidden rounded-2xl border border-rose-200 bg-white shadow-sm">
                    <div class="border-b border-rose-100 bg-rose-50/50 px-6 py-4">
                        <h3 class="font-bold text-rose-900">Revocar permisos de ingreso</h3>
                        <p class="text-xs text-rose-600 mt-0.5">Acciones restrictivas de control de usuarios.</p>
                    </div>
                    <div class="p-6 md:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="max-w-xl">
                            <h4 class="text-sm font-bold text-slate-900">Deshabilitar acceso al sistema</h4>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">
                                Bloquea de forma inmediata el ingreso de <span class="font-semibold text-slate-700">{{ $usuario->nombre }}</span> a la plataforma y cierra todas sus sesiones activas. Por motivos de auditoría interna y seguridad contable, sus registros históricos y movimientos de caja permanecerán completamente inmutables.
                            </p>
                        </div>

                        <form action="{{ route('usuarios.baja', $usuario) }}" method="POST" class="shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                                Dar de baja usuario
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-sm">
                    <div class="border-b border-emerald-100 bg-emerald-50/50 px-6 py-4">
                        <h3 class="font-bold text-emerald-900">Reactivación de Cuenta</h3>
                        <p class="text-xs text-emerald-600 mt-0.5">Restaurar accesos para personal suspendido.</p>
                    </div>

                    <form action="{{ route('usuarios.reactivar') }}" method="POST" class="p-6 md:p-8 space-y-5">
                        @csrf
                        <div class="max-w-xl">
                            <p class="text-sm text-slate-600 leading-relaxed">
                                El usuario se encuentra actualmente dado de baja. Para devolverle el acceso a los módulos de mostrador, confirma su identificación e ingresa una nueva credencial provisoria.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 max-w-2xl">
                            <div>
                                <label for="dni_reactivar" class="block text-sm font-semibold text-slate-700">DNI de Confirmación</label>
                                <input
                                    type="number"
                                    id="dni_reactivar"
                                    value="{{ $usuario->dni }}"
                                    disabled
                                    class="mt-1.5 block w-full rounded-lg border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 shadow-sm cursor-not-allowed"
                                >
                                <input type="hidden" name="dni" value="{{ $usuario->dni }}">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700">Contraseña Temporal <span class="text-rose-500">*</span></label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Mínimo 8 caracteres"
                                    class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-emerald-500 focus:bg-white focus:ring-emerald-500"
                                    required
                                >
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-slate-100 pt-4">
                            <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                Reactivar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>