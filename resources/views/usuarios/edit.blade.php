<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Modificar Usuario
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                    <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800 shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-rose-900">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        Se encontraron errores de validaci&oacute;n:
                    </div>
                    <ul class="mt-2 list-disc space-y-1 pl-5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-900">Datos de la Cuenta</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Modifica los permisos y la informaci&oacute;n del personal autorizado.</p>
                </div>

                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-6 p-6 md:p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="dni" class="block text-sm font-semibold text-slate-700">Documento Nacional de Identidad (DNI)</label>
                            <input
                                type="text"
                                id="dni"
                                value="{{ $usuario->dni }}"
                                disabled
                                class="mt-1.5 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0"
                            >
                        </div>

                        <div>
                            <label for="rol" class="block text-sm font-semibold text-slate-700">Rol asignado <span class="text-rose-500">*</span></label>
                            <select name="rol" id="rol" required class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                                <option value="{{ \App\Enums\RolUsuario::GERENTE->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::GERENTE->value ? 'selected' : '' }}>Gerente</option>
                                <option value="{{ \App\Enums\RolUsuario::ENCARGADO->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::ENCARGADO->value ? 'selected' : '' }}>Encargado</option>
                            </select>
                            @error('rol')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-slate-700">Nombre <span class="text-rose-500">*</span></label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre"
                                value="{{ old('nombre', $usuario->nombre) }}"
                                oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                            @error('nombre')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-semibold text-slate-700">Apellido <span class="text-rose-500">*</span></label>
                            <input
                                type="text"
                                name="apellido"
                                id="apellido"
                                value="{{ old('apellido', $usuario->apellido) }}"
                                oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                            @error('apellido')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-slate-700">Correo Electr&oacute;nico / Nombre de Usuario <span class="text-rose-500">*</span></label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $usuario->email) }}"
                                required
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
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
                        <p class="mt-0.5 text-xs text-rose-600">Acciones restrictivas de control de usuarios.</p>
                    </div>
                    <div class="flex flex-col gap-4 p-6 md:flex-row md:items-center md:justify-between md:p-8">
                        <div class="max-w-xl">
                            <h4 class="text-sm font-bold text-slate-900">Deshabilitar acceso al sistema</h4>
                            <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                Bloquea de forma inmediata el ingreso de <span class="font-semibold text-slate-700">{{ $usuario->nombre }}</span> a la plataforma y conserva sus registros hist&oacute;ricos.
                            </p>
                        </div>

                        <form action="{{ route('usuarios.baja', $usuario) }}" method="POST" class="shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6.75h3m-4.5 3h6m-6 3h6m2.25-9a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 17.25 18H6.75a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 6.75 4.5h10.5Z" />
                                </svg>
                                Dar de baja usuario
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-sm">
                    <div class="border-b border-emerald-100 bg-emerald-50/50 px-6 py-4">
                        <h3 class="font-bold text-emerald-900">Reactivaci&oacute;n de Cuenta</h3>
                        <p class="mt-0.5 text-xs text-emerald-600">Restaurar accesos para personal suspendido.</p>
                    </div>

                    <form action="{{ route('usuarios.reactivar') }}" method="POST" class="space-y-5 p-6 md:p-8">
                        @csrf
                        <div class="max-w-xl">
                            <p class="text-sm leading-relaxed text-slate-600">
                                El usuario se encuentra actualmente dado de baja. Para devolverle el acceso, confirma su identificaci&oacute;n e ingresa una nueva credencial provisoria.
                            </p>
                        </div>

                        <div class="grid max-w-2xl grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="dni_reactivar" class="block text-sm font-semibold text-slate-700">DNI de Confirmaci&oacute;n</label>
                                <input
                                    type="text"
                                    id="dni_reactivar"
                                    value="{{ $usuario->dni }}"
                                    disabled
                                    class="mt-1.5 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 shadow-sm"
                                >
                                <input type="hidden" name="dni" value="{{ $usuario->dni }}">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700">Contrase&ntilde;a Temporal <span class="text-rose-500">*</span></label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="M&iacute;nimo 8 caracteres"
                                    class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-emerald-500 focus:bg-white focus:ring-emerald-500"
                                    required
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-slate-100 pt-4">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6a7.5 7.5 0 1 0 0 12M16.5 6v4.5m0-4.5H12" />
                                </svg>
                                Reactivar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
