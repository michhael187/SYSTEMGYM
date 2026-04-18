<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Pago
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

                <div class="mb-8 rounded-md border border-gray-200 p-4">
                    <h3 class="mb-4 text-lg font-semibold text-gray-800">Buscar cliente</h3>

                    <form action="{{ route('pagos.create') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="tipo_busqueda" class="block text-sm font-medium text-gray-700">Buscar por</label>
                            <select
                                name="tipo_busqueda"
                                id="tipo_busqueda"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            >
                                <option value="dni" {{ $tipoBusqueda === 'dni' ? 'selected' : '' }}>DNI</option>
                                <option value="apellido" {{ $tipoBusqueda === 'apellido' ? 'selected' : '' }}>Apellido</option>
                            </select>
                        </div>

                        <div>
                            <label for="valor_busqueda" class="block text-sm font-medium text-gray-700">Valor de búsqueda</label>
                            <input
                                type="text"
                                name="valor_busqueda"
                                id="valor_busqueda"
                                value="{{ $valorBusqueda }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Ingrese DNI o apellido"
                            >
                        </div>

                        <div>
                            <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                                Buscar Cliente
                            </button>
                        </div>
                    </form>

                    @if ($valorBusqueda !== '')
                        <div class="mt-6">
                            <h4 class="mb-3 text-md font-semibold text-gray-800">Resultados</h4>

                            @if ($clientes->isEmpty())
                                <div class="rounded-md bg-yellow-100 px-4 py-3 text-yellow-800">
                                    No se encontraron clientes con ese criterio de búsqueda.
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($clientes as $cliente)
                                        <label class="block rounded-md border border-gray-200 px-4 py-3">
                                            <input
                                                type="radio"
                                                name="cliente_id_seleccionado"
                                                value="{{ $cliente->id }}"
                                                form="form-registrar-pago"
                                                {{ old('cliente_id') == $cliente->id ? 'checked' : '' }}
                                            >
                                            <span class="ml-2 font-semibold text-gray-800">
                                                {{ $cliente->apellido }}, {{ $cliente->nombre }}
                                            </span>
                                            <span class="block text-sm text-gray-600 ml-6">
                                                DNI: {{ $cliente->dni }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <form id="form-registrar-pago" action="{{ route('pagos.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <input type="hidden" name="cliente_id" value="{{ old('cliente_id') }}">

                    <div>
                        <label for="membresia_id" class="block text-sm font-medium text-gray-700">Membresía</label>
                        <select
                            name="membresia_id"
                            id="membresia_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">Seleccione una membresía</option>
                            @foreach ($membresias as $membresia)
                                <option value="{{ $membresia->id }}" {{ old('membresia_id') == $membresia->id ? 'selected' : '' }}>
                                    {{ $membresia->nombre_plan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha de pago</label>
                        <input
                            type="datetime-local"
                            name="fecha_pago"
                            id="fecha_pago"
                            value="{{ old('fecha_pago', now()->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Registrar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="cliente_id_seleccionado"]');
            const hiddenClienteId = document.querySelector('input[name="cliente_id"]');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    hiddenClienteId.value = this.value;
                });
            });
        });
    </script>
</x-app-layout>
