<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modificar Membresia
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

                <form action="{{ route('membresias.update', $membresia) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nombre_plan" class="block text-sm font-medium text-gray-700">Nombre del plan</label>
                        <input
                            type="text"
                            name="nombre_plan"
                            id="nombre_plan"
                            value="{{ old('nombre_plan', $membresia->nombre_plan) }}"
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
                            value="{{ old('precio', $membresia->precio) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="duracion_dias" class="block text-sm font-medium text-gray-700">Duracion en dias</label>
                        <input
                            type="number"
                            name="duracion_dias"
                            id="duracion_dias"
                            value="{{ old('duracion_dias', $membresia->duracion_dias) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="activo" class="block text-sm font-medium text-gray-700">Estado actual</label>
                        <input
                            type="text"
                            id="activo"
                            value="{{ $membresia->activo ? 'Activa' : 'Inactiva' }}"
                            disabled
                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                        >
                    </div>

                    <div>
                        <button type="submit" style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <hr class="my-6">

                <div>
                    @if ($membresia->activo)
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Baja logica de la membresia</h3>
                        <p class="mb-4 text-sm text-gray-600">
                            Esta accion deja la membresia inactiva para nuevos pagos, pero conserva su historial.
                        </p>

                        <form action="{{ route('membresias.baja', $membresia) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit" style="background:#b91c1c; color:white; padding:10px 16px; border-radius:6px;">
                                Dar de Baja Membresia
                            </button>
                        </form>
                    @else
                        <h3 class="mb-3 text-lg font-semibold text-gray-800">Reactivar membresia</h3>
                        <p class="mb-4 text-sm text-gray-600">
                            Esta accion vuelve a dejar disponible la membresia para nuevos pagos.
                        </p>

                        <form action="{{ route('membresias.reactivar', $membresia) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit" style="background:#15803d; color:white; padding:10px 16px; border-radius:6px;">
                                Reactivar Membresia
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
