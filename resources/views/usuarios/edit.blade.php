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
                        <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="rol" id="rol" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="gerente" {{ old('rol', $usuario->rol) === 'gerente' ? 'selected' : '' }}>Gerente</option>
                            <option value="encargado" {{ old('rol', $usuario->rol) === 'encargado' ? 'selected' : '' }}>Encargado</option>
                        </select>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre', $usuario->nombre) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            value="{{ old('apellido', $usuario->apellido) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $usuario->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ old('estado', (string) $usuario->estado) === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', (string) $usuario->estado) === '0' ? 'selected' : '' }}>No Activo</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <hr class="my-6">

                <div>
                    <h3 class="mb-3 text-lg font-semibold text-gray-800">Baja lógica del usuario</h3>
                    <p class="mb-4 text-sm text-gray-600">
                        Esta acción cambia el estado del usuario a inactivo, pero no elimina su registro del sistema.
                    </p>

                    <form action="{{ route('usuarios.baja', $usuario) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" style="background:#b91c1c; color:white; padding:10px 16px; border-radius:6px;">
                            Dar de Baja Usuario
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
