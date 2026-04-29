<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alta de Usuario
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

                @if (session('warning'))
                    <div class="mb-4 rounded-md bg-yellow-100 px-4 py-3 text-yellow-800">
                        {{ session('warning') }}
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

                <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="rol" id="rol" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Seleccione un rol</option>
                            <option value="{{ \App\Enums\RolUsuario::GERENTE->value }}" {{ old('rol') === \App\Enums\RolUsuario::GERENTE->value ? 'selected' : '' }}>Gerente</option>
                            <option value="{{ \App\Enums\RolUsuario::ENCARGADO->value }}" {{ old('rol') === \App\Enums\RolUsuario::ENCARGADO->value ? 'selected' : '' }}>Encargado</option>
                        </select>
                    </div>

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input type="number" name="dni" id="dni" value="{{ old('dni') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña temporal</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ old('estado') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>No Activo</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                            Registrar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
