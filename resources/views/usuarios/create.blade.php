<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Alta de Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
                    <span class="font-bold">&iexcl;&Eacute;xito!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700 shadow-sm">
                    &#9888;&#65039; {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                    <strong class="font-bold">Revisa los siguientes errores:</strong>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-5">
                    <h3 class="text-lg font-semibold text-slate-800">Datos de la Cuenta</h3>
                    <p class="text-sm text-slate-500">Completa la informaci&oacute;n para dar acceso al sistema.</p>
                </div>

                <form action="{{ route('usuarios.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="rol" class="mb-1 block text-sm font-medium text-slate-700">Nivel de Acceso (Rol) <span class="text-rose-500">*</span></label>
                            <select name="rol" id="rol" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-base shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                                <option value="">-- Seleccione un rol --</option>
                                <option value="{{ \App\Enums\RolUsuario::GERENTE->value }}" {{ old('rol') === \App\Enums\RolUsuario::GERENTE->value ? 'selected' : '' }}>Gerente (Acceso Total)</option>
                                <option value="{{ \App\Enums\RolUsuario::ENCARGADO->value }}" {{ old('rol') === \App\Enums\RolUsuario::ENCARGADO->value ? 'selected' : '' }}>Encargado (Mostrador y Cobros)</option>
                            </select>
                            @error('rol')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dni" class="mb-1 block text-sm font-medium text-slate-700">DNI <span class="text-rose-500">*</span></label>
                            <input type="text" inputmode="numeric" name="dni" id="dni" value="{{ old('dni') }}" placeholder="Ej: 35123456" oninput="this.value = this.value.replace(/\D/g, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('dni')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Correo Electr&oacute;nico <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="usuario@systemgym.com" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('email')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nombre" class="mb-1 block text-sm font-medium text-slate-700">Nombre <span class="text-rose-500">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido" class="mb-1 block text-sm font-medium text-slate-700">Apellido <span class="text-rose-500">*</span></label>
                            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('apellido')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="my-2 md:col-span-2 border-t border-slate-100"></div>

                        <div>
                            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contrase&ntilde;a Temporal <span class="text-rose-500">*</span></label>
                            <input type="password" name="password" id="password" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('password')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Asigna una clave provisoria. El usuario podr&aacute; cambiarla luego.</p>
                        </div>

                        <div>
                            <label for="estado" class="mb-1 block text-sm font-medium text-slate-700">Estado de la Cuenta <span class="text-rose-500">*</span></label>
                            <select name="estado" id="estado" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                                <option value="1" {{ old('estado') === '1' ? 'selected' : '' }}>&#x1F7E2; Activo (Permitir ingreso)</option>
                                <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>&#x1F534; Suspendido (Bloquear acceso)</option>
                            </select>
                            @error('estado')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                        <a href="{{ route('usuarios.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                            Cancelar
                        </a>
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Registrar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
