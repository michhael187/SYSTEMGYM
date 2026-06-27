<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver / Modificar Cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Volver a Clientes
                </a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
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
                        <label for="dni_visible" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input type="text" id="dni_visible" value="{{ $cliente->dni }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                        <input type="hidden" name="dni" value="{{ $cliente->dni }}">
                        @error('dni')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-600">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" placeholder="Ej: Juan" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido <span class="text-red-600">*</span></label>
                        <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $cliente->apellido) }}" placeholder="Ej: P&eacute;rez" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('apellido')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Tel&eacute;fono <span class="text-red-600">*</span></label>
                        <input type="text" inputmode="numeric" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}" placeholder="Ej: 2902456789" oninput="this.value = this.value.replace(/\D/g, '')" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="membresia_actual" class="block text-sm font-medium text-gray-700">Membres&iacute;a actual (solo consulta)</label>
                        <input type="text" id="membresia_actual" value="{{ $cliente->membresiaActual?->nombre_plan ?? 'Sin membresia' }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                    </div>

                    <div>
                        <label for="fecha_ultimo_pago" class="block text-sm font-medium text-gray-700">Fecha &uacute;ltimo pago (solo consulta)</label>
                        <input type="text" id="fecha_ultimo_pago" value="{{ optional($cliente->fecha_ultimo_pago)->format('d/m/Y H:i') ?? 'Sin registro' }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                    </div>

                    <div>
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha vencimiento (calculada autom&aacute;ticamente)</label>
                        <input type="date" id="fecha_vencimiento" value="{{ optional($cliente->fecha_vencimiento)->format('Y-m-d') }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                        <p class="mt-1 text-sm text-gray-500">
                            La fecha de vencimiento se calcula autom&aacute;ticamente seg&uacute;n la membres&iacute;a y la fecha del &uacute;ltimo pago.
                        </p>
                    </div>

                    <div>
                        <label for="peso" class="block text-sm font-medium text-gray-700">Peso (kg) (Opcional)</label>
                        <input type="text" inputmode="decimal" name="peso" id="peso" value="{{ old('peso', $cliente->peso) }}" placeholder="Ej: 75.5" oninput="this.value = this.value.replace(/[^0-9.,]/g, '')" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('peso')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="altura" class="block text-sm font-medium text-gray-700">Altura (cm) (Opcional)</label>
                        <input type="text" inputmode="decimal" name="altura" id="altura" value="{{ old('altura', $cliente->altura) }}" placeholder="Ej: 175" oninput="this.value = this.value.replace(/[^0-9.,]/g, '')" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('altura')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones (Opcional)</label>
                        <textarea name="observaciones" id="observaciones" rows="4" placeholder="Ej: Lesi&oacute;n previa en rodilla derecha." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('observaciones', $cliente->observaciones) }}</textarea>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado del Cliente (Activo/Inactivo) <span class="text-red-600">*</span></label>
                        <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="1" {{ old('estado', (string) $cliente->estado) === '1' ? 'selected' : '' }}>&#x1F7E2; Activo</option>
                            <option value="0" {{ old('estado', (string) $cliente->estado) === '0' ? 'selected' : '' }}>&#x1F534; Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Determina si el cliente se encuentra vigente o inactivo.</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                        <a href="{{ route('clientes.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
