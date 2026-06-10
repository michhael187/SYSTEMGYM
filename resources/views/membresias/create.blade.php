<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Crear Nueva Membresía / Plan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            
            <div class="mb-6 space-y-4">
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 shadow-sm">
                        <span class="font-bold">¡Excelente!</span> {{ session('success') }}
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

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-5">
                    <h3 class="text-lg font-semibold text-slate-800">Detalles de la Tarifa</h3>
                    <p class="text-sm text-slate-500">Configura el nombre, el valor y la duración de este plan.</p>
                </div>

                <form action="{{ route('membresias.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        
                        <div class="md:col-span-2">
                            <label for="nombre_plan" class="mb-1 block text-sm font-medium text-slate-700">Nombre del Plan <span class="text-rose-500">*</span></label>
                            <input 
                                type="text" 
                                name="nombre_plan" 
                                id="nombre_plan" 
                                value="{{ old('nombre_plan') }}" 
                                placeholder="Ej: Pase Libre Mensual, Musculación Trimestral..." 
                                class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                required
                            >
                        </div>

                        <div>
                            <label for="precio" class="mb-1 block text-sm font-medium text-slate-700">Precio Promocional / Final <span class="text-rose-500">*</span></label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-500 sm:text-sm">$</span>
                                </div>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="precio" 
                                    id="precio" 
                                    value="{{ old('precio') }}" 
                                    placeholder="0.00" 
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
                                    value="{{ old('duracion_dias') }}" 
                                    placeholder="Ej: 30" 
                                    class="block w-full rounded-lg border-slate-300 bg-slate-50 pr-12 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                    required
                                >
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-slate-500 sm:text-sm">días</span>
                                </div>
                            </div>
                        </div>

                        <div class="my-2 border-t border-slate-100 md:col-span-2"></div>

                        <div class="md:col-span-2">
                            <label for="activo" class="mb-1 block text-sm font-medium text-slate-700">Estado de Comercialización</label>
                            <select name="activo" id="activo" class="block w-full md:w-1/2 rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                                <option value="1" {{ old('activo', '1') === '1' ? 'selected' : '' }}>🟢 Activo (Visible para cobrar)</option>
                                <option value="0" {{ old('activo') === '0' ? 'selected' : '' }}>🔴 Inactivo (Oculto)</option>
                            </select>
                            <p class="mt-2 text-xs text-slate-500">Si un plan cambia de precio, desactiva este y crea uno nuevo para no alterar la contabilidad histórica.</p>
                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                        <a href="{{ route('membresias.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                            Cancelar
                        </a>
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Registrar Membresía
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>