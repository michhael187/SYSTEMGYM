<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buscar Cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
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

                <form action="{{ route('clientes.buscar') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="tipo_busqueda" class="block text-sm font-medium text-gray-700">Buscar por</label>
                        <select
                            name="tipo_busqueda"
                            id="tipo_busqueda"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="dni" {{ old('tipo_busqueda') === 'dni' ? 'selected' : '' }}>DNI</option>
                            <option value="apellido" {{ old('tipo_busqueda') === 'apellido' ? 'selected' : '' }}>Apellido</option>
                        </select>
                    </div>

                    <div>
                        <label for="valor" class="block text-sm font-medium text-gray-700">Valor de búsqueda</label>
                        <input
                            type="text"
                            name="valor"
                            id="valor"
                            value="{{ old('valor') }}"
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

                @isset($resultados)
                    <div class="mt-8">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Resultados encontrados</h3>

                        <div class="space-y-3">
                            @foreach ($resultados as $cliente)
                                <div class="rounded-md border border-gray-200 px-4 py-3">
                                    <div class="font-semibold text-gray-800">
                                        {{ $cliente->apellido }}, {{ $cliente->nombre }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        DNI: {{ $cliente->dni }}
                                    </div>

                                    <div class="mt-3">
                                        <a
                                            href="{{ route('clientes.edit', $cliente) }}"
                                            style="background:#2563eb; color:white; padding:8px 14px; border-radius:6px; text-decoration:none; display:inline-block;"
                                        >
                                            Ver / Modificar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</x-app-layout>
