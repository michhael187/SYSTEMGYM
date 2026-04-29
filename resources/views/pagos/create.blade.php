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
                            <label for="valor_busqueda" class="block text-sm font-medium text-gray-700">Valor de busqueda</label>
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

                    @if ($clientePreseleccionado && $valorBusqueda === '')
                        <div class="mt-6 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800">
                            <p class="font-semibold">Cliente preseleccionado para registrar el primer pago.</p>
                            <p class="mt-1 text-sm">
                                {{ $clientePreseleccionado->apellido }}, {{ $clientePreseleccionado->nombre }} - DNI: {{ $clientePreseleccionado->dni }}
                            </p>
                        </div>
                    @elseif ($valorBusqueda !== '')
                        <div class="mt-6">
                            <h4 class="mb-3 text-md font-semibold text-gray-800">Resultados</h4>

                            @if ($clientes->isEmpty())
                                <div class="rounded-md bg-yellow-100 px-4 py-3 text-yellow-800">
                                    No se encontraron clientes con ese criterio de busqueda.
                                </div>
                            @else
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                                    Se encontraron {{ $clientes->count() }} cliente(s). Seleccionalo en el formulario de pago.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <form id="form-registrar-pago" action="{{ route('pagos.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select
                            name="cliente_id"
                            id="cliente_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">Seleccione un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id', $clientePreseleccionado?->id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->apellido }}, {{ $cliente->nombre }} - DNI: {{ $cliente->dni }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="membresia_id" class="block text-sm font-medium text-gray-700">Membresia</label>
                        <select
                            name="membresia_id"
                            id="membresia_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">Seleccione una membresia</option>
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
</x-app-layout>
