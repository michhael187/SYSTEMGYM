<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
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

                <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input
                            type="number"
                            name="dni"
                            id="dni"
                            value="{{ old('dni') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            value="{{ old('apellido') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input
                            type="text"
                            name="telefono"
                            id="telefono"
                            value="{{ old('telefono') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="membresia_actual_id" class="block text-sm font-medium text-gray-700">Membresía actual</label>
                        <select
                            name="membresia_actual_id"
                            id="membresia_actual_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">Seleccione una membresía</option>
                            @foreach ($membresias as $membresia)
                                <option value="{{ $membresia->id }}" {{ old('membresia_actual_id') == $membresia->id ? 'selected' : '' }}>
                                    {{ $membresia->nombre_plan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_ultimo_pago" class="block text-sm font-medium text-gray-700">Fecha último pago</label>
                        <input
                            type="datetime-local"
                            name="fecha_ultimo_pago"
                            id="fecha_ultimo_pago"
                            value="{{ old('fecha_ultimo_pago', now()->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso</label>
                        <input
                            type="number"
                            step="0.01"
                            name="peso"
                            id="peso"
                            value="{{ old('peso') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura</label>
                        <input
                            type="number"
                            step="0.01"
                            name="altura"
                            id="altura"
                            value="{{ old('altura') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                        <textarea
                            name="observaciones"
                            id="observaciones"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('observaciones') }}</textarea>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ old('estado', '1') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Registrar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
