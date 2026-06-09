<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modificar Usuario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-red-800">
                        <strong>Se encontraron errores:</strong>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input
                            type="number"
                            id="dni"
                            value="{{ $usuario->dni }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="rol" class="block text-sm font-medium text-gray-700">Rol <span class="text-red-600">*</span></label>
                        <select name="rol" id="rol" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="{{ \App\Enums\RolUsuario::GERENTE->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::GERENTE->value ? 'selected' : '' }}>Gerente</option>
                            <option value="{{ \App\Enums\RolUsuario::ENCARGADO->value }}" {{ old('rol', $usuario->rol) === \App\Enums\RolUsuario::ENCARGADO->value ? 'selected' : '' }}>Encargado</option>
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre', $usuario->nombre) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            value="{{ old('apellido', $usuario->apellido) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $usuario->email) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <hr class="my-6">

                @if ($usuario->estado)
                    <div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Deshabilitar acceso</h3>
                        <p class="mb-4 text-sm text-gray-600">
                            Esta acción revoca los permisos del usuario para ingresar al sistema, pero mantiene su historial intacto.
                        </p>

                        <form action="{{ route('usuarios.baja', $usuario) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit" style="background:#b91c1c; color:white; padding:10px 16px; border-radius:6px;">
                                Dar de baja usuario
                            </button>
                        </form>
                    </div>
                @else
                    <div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Reactivar acceso</h3>
                        <p class="mb-4 text-sm text-gray-600">
                            Esta acción restaura los permisos del usuario, permitiéndole ingresar nuevamente al sistema.
                        </p>

                        <form action="{{ route('usuarios.reactivar') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="dni_reactivar" class="block text-sm font-medium text-gray-700">DNI</label>
                                <input
                                    type="number"
                                    id="dni_reactivar"
                                    value="{{ $usuario->dni }}"
                                    disabled
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                                >
                                <input type="hidden" name="dni" value="{{ $usuario->dni }}">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña temporal</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    required
                                >
                            </div>

                            <button type="submit" style="background:#15803d; color:white; padding:10px 16px; border-radius:6px;">
                                Reactivar usuario
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
