<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Membresía
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

                <form action="{{ route('membresias.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nombre_plan" class="block text-sm font-medium text-gray-700">Nombre del plan</label>
                        <input
                            type="text"
                            name="nombre_plan"
                            id="nombre_plan"
                            value="{{ old('nombre_plan') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input
                            type="number"
                            step="0.01"
                            name="precio"
                            id="precio"
                            value="{{ old('precio') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="duracion_dias" class="block text-sm font-medium text-gray-700">Duración en días</label>
                        <input
                            type="number"
                            name="duracion_dias"
                            id="duracion_dias"
                            value="{{ old('duracion_dias') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Registrar Membresía
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
