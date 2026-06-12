<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver / Modificar Cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input
                            type="number"
                            id="dni"
                            value="{{ $cliente->dni }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre', $cliente->nombre) }}"
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
                            value="{{ old('apellido', $cliente->apellido) }}"
                            placeholder="Ej: Pérez"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono <span class="text-red-600">*</span></label>
                        <input
                            type="text"
                            name="telefono"
                            id="telefono"
                            value="{{ old('telefono', $cliente->telefono) }}"
                            required
                            placeholder="Ej: 2902456789"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="membresia_actual" class="block text-sm font-medium text-gray-700">Membresia actual (solo consulta)</label>
                        <input
                            type="text"
                            id="membresia_actual"
                            value="{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia' }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="fecha_ultimo_pago" class="block text-sm font-medium text-gray-700">Fecha ultimo pago (solo consulta)</label>
                        <input
                            type="text"
                            id="fecha_ultimo_pago"
                            value="{{ optional($cliente->fecha_ultimo_pago)->format('d/m/Y H:i') ?? 'Sin registro' }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha vencimiento (calculada automaticamente)</label>
                        <input
                            type="date"
                            id="fecha_vencimiento"
                            value="{{ optional($cliente->fecha_vencimiento)->format('Y-m-d') }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                        <p class="mt-1 text-sm text-gray-500">
                            La fecha de vencimiento se calcula automaticamente segun la membresia y la fecha del ultimo pago.
                        </p>
                    </div>

                    <div>
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg) (Opcional)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="peso"
                            id="peso"
                            value="{{ old('peso', $cliente->peso) }}"
                            placeholder="Ej: 75.5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm) (Opcional)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="altura"
                            id="altura"
                            value="{{ old('altura', $cliente->altura) }}"
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
                            placeholder="Ej: Lesión previa en rodilla derecha."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('observaciones', $cliente->observaciones) }}</textarea>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado del Cliente (Activo/Inactivo) <span class="text-red-600">*</span></label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="1" {{ old('estado', (string) $cliente->estado) === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', (string) $cliente->estado) === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">
                            Determina si el cliente se encuentra vigente o inactivo.
                        </p>
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
