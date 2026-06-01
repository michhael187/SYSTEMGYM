<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                        <p class="font-semibold">{{ session('success') }}</p>

                        @if (session('cliente_creado_id'))
                            <p class="mt-2 text-sm">
                                Cliente registrado: {{ session('cliente_creado_nombre') }}.
                            </p>

                            <div class="mt-4">
                                <a
                                    href="{{ route('pagos.create', ['cliente_id' => session('cliente_creado_id')]) }}"
                                    class="inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700"
                                >
                                    Registrar Primer Pago
                                </a>
                            </div>
                        @endif
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

                <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI <span class="text-red-600">*</span></label>
                        <input
                            type="number"
                            name="dni"
                            id="dni"
                            value="{{ old('dni') }}"
                            placeholder="Ej: 35123456"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Juan"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            value="{{ old('apellido') }}"
                            placeholder="Ej: Pérez"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono <span class="text-red-600">*</span></label>
                        <input
                            type="number"
                            name="telefono"
                            id="telefono"
                            value="{{ old('telefono') }}"
                            required
                            placeholder="Ej: 2902456789"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg) (Opcional)</label>
                        <input
                            type="number"
                            step="0.1"
                            name="peso"
                            id="peso"
                            value="{{ old('peso') }}"
                            placeholder="Ej: 75.5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm) (Opcional)</label>
                        <input
                            type="number"
                            name="altura"
                            id="altura"
                            value="{{ old('altura') }}"
                            placeholder="Ej: 175"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones (Opcional)</label>
                        <textarea
                            name="observaciones"
                            id="observaciones"
                            rows="4"
                            placeholder="Ej: Lesión previa en rodilla derecha / Ninguna."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('observaciones') }}</textarea>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado <span class="text-red-600">*</span></label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ old('estado', '1') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        La membresia y la fecha del ultimo pago se asignaran cuando registres el primer pago del cliente.
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
