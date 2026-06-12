<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Editar Tarifa / Plan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            
            <div class="mb-6 space-y-4">
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 shadow-sm">
                        <span class="font-bold">¡Guardado!</span> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                        <strong class="font-bold">Revisa los siguientes errores:</strong>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm mb-6">
                
                <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-8 py-5">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Detalles de la Membresía</h3>
                        <p class="text-sm text-slate-500">Modifica los valores comerciales de este plan.</p>
                    </div>
                    
                    <div>
                        @if ($membresia->activo)
                            <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Comercialmente Activa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                Inactiva (Oculta)
                            </span>
                        @endif
                    </div>
                </div>

                <form action="{{ route('membresias.update', $membresia) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        
                        <div class="md:col-span-2">
                            <label for="nombre_plan" class="mb-1 block text-sm font-medium text-slate-700">Nombre del Plan <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="nombre_plan" 
                                id="nombre_plan" 
                                value="{{ old('nombre_plan', $membresia->nombre_plan) }}" 
                                class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                required
                            >
                        </div>

                        <div>
                            <label for="precio" class="mb-1 block text-sm font-medium text-slate-700">Precio de Venta <span class="text-rose-500">*</span></label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-500 sm:text-sm">$</span>
                                </div>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="precio" 
                                    id="precio" 
                                    value="{{ old('precio', $membresia->precio) }}" 
                                    class="block w-full rounded-lg border-slate-300 bg-slate-50 pl-7 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <label for="duracion_dias" class="mb-1 block text-sm font-medium text-slate-700">Duración <span class="text-rose-500">*</span></label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <input 
                                    type="number" 
                                    name="duracion_dias" 
                                    id="duracion_dias" 
                                    value="{{ old('duracion_dias', $membresia->duracion_dias) }}" 
                                    class="block w-full rounded-lg border-slate-300 bg-slate-50 pr-12 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                    required
                                >
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-slate-500 sm:text-sm">días</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                        <a href="{{ route('membresias.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                            Volver al Listado
                        </a>
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border {{ $membresia->activo ? 'border-rose-200 bg-rose-50/50' : 'border-emerald-200 bg-emerald-50/50' }} p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    
                    @if ($membresia->activo)
                        <div>
                            <h3 class="text-lg font-bold text-rose-800">Desactivar Membresía</h3>
                            <p class="mt-1 text-sm text-rose-600/80 max-w-lg">
                                Esta acción quitará este plan de la lista de ventas. Los socios que ya pagaron este plan conservarán su historial sin problemas.
                            </p>
                        </div>
                        <form action="{{ route('membresias.baja', $membresia) }}" method="POST" class="shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full sm:w-auto rounded-xl bg-rose-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 focus:ring-offset-rose-50">
                                Dar de Baja
                            </button>
                        </form>
                    @else
                        <div>
                            <h3 class="text-lg font-bold text-emerald-800">Reactivar Membresía</h3>
                            <p class="mt-1 text-sm text-emerald-600/80 max-w-lg">
                                Esta acción volverá a publicar este plan en la recepción, permitiendo que se cobren nuevas cuotas con estos valores.
                            </p>
                        </div>
                        <form action="{{ route('membresias.reactivar', $membresia) }}" method="POST" class="shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full sm:w-auto rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-emerald-50">
                                Reactivar Plan
                            </button>
                        </form>
                    @endif
                    
                </div>
            </div>

        </div>
    </div>
</x-app-layout>