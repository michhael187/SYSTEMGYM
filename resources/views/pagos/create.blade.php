<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Registrar Nuevo Cobro
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            <!-- Alertas de Éxito o Error -->
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
                    <span class="font-bold">¡Excelente!</span> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                    <strong class="font-bold">No se pudo procesar el pago:</strong>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Contenedor Principal a 2 Columnas -->
            <div class="grid gap-6 lg:grid-cols-12">
                
                <!-- COLUMNA IZQUIERDA: Búsqueda de Cliente -->
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-800">Paso 1: Identificar Socio</h3>
                        </div>

                        <!-- Formulario de Búsqueda -->
                        <form action="{{ route('pagos.create') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="col-span-1">
                                    <label for="tipo_busqueda" class="mb-1 block text-xs font-medium text-slate-500 uppercase tracking-wider">Filtro</label>
                                    <select name="tipo_busqueda" id="tipo_busqueda" class="block w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="apellido" {{ ($tipoBusqueda ?? 'apellido') === 'apellido' ? 'selected' : '' }}>
                                            Apellido
                                        </option>
                                        
                                        <option value="dni" {{ ($tipoBusqueda ?? '') === 'dni' ? 'selected' : '' }}>
                                            DNI
                                        </option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label for="valor_busqueda" class="mb-1 block text-xs font-medium text-slate-500 uppercase tracking-wider">Dato a buscar</label>
                                    <input type="text" name="valor_busqueda" id="valor_busqueda" value="{{ $valorBusqueda }}" placeholder="Ej: 41000001" class="block w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="submit" class="w-full rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700">
                                Buscar Cliente
                            </button>
                        </form>

                        <!-- Resultados de Búsqueda Visuales -->
                        @if ($valorBusqueda !== '')
                            <div class="mt-6 border-t border-slate-100 pt-5">
                                @if ($clientes->isEmpty())
                                    <div class="rounded-lg bg-rose-50 px-4 py-3 text-sm text-rose-700 border border-rose-100">
                                        ⚠️ No hay socios registrados con ese dato.
                                    </div>
                                @else
                                    <div class="rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800 border border-emerald-100">
                                        <span class="font-bold">✓ Búsqueda exitosa.</span> Selecciona al socio en el panel derecho.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- COLUMNA DERECHA: Formulario de Cobro -->
                <div class="lg:col-span-7">
                    <form id="form-registrar-pago" action="{{ route('pagos.store') }}" method="POST" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        @csrf
                        
                        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.768 0-1.536-.219-2.121-.659-1.172-.879-1.172-2.303 0-3.182 1.171-.879 3.07-.879 4.242 0l.415.311M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-800">Paso 2: Detalles del Cobro</h3>
                        </div>

                        <div class="space-y-6">
                            
                            <!-- Selección de Cliente -->
                            <div>
                                <label for="cliente_id" class="mb-1 block text-sm font-medium text-slate-700">Cliente a cobrar</label>
                                <select name="cliente_id" id="cliente_id" class="block w-full rounded-lg border-slate-300 text-base shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-slate-50">
                                    <option value="">-- Seleccione un cliente de la lista --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $clientePreseleccionado?->id) == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->apellido }}, {{ $cliente->nombre }} (DNI: {{ $cliente->dni }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selección de Membresía (AHORA CON PRECIO) -->
                            <div>
                                <label for="membresia_id" class="mb-1 block text-sm font-medium text-slate-700">Plan / Membresía</label>
                                <select name="membresia_id" id="membresia_id" class="block w-full rounded-lg border-slate-300 text-base shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Seleccione el plan a cobrar --</option>
                                    @foreach ($membresias as $membresia)
                                        <option value="{{ $membresia->id }}" {{ old('membresia_id') == $membresia->id ? 'selected' : '' }}>
                                            <!-- IMPORTANTE: Cambia "precio" por el nombre real de tu columna en la BD si es diferente -->
                                            {{ $membresia->nombre_plan }} - $ {{ number_format($membresia->precio ?? 0, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Componente Alpine.js para la Fecha Segura -->
                            <div x-data="{ modificarFecha: false }" class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <label for="fecha_pago" class="block text-sm font-medium text-slate-700">Fecha y Hora de Pago</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="modificarFecha" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <span class="ml-2 text-xs font-medium text-slate-500">Modificar fecha</span>
                                    </label>
                                </div>
                                <input 
                                    type="datetime-local" 
                                    name="fecha_pago" 
                                    id="fecha_pago" 
                                    value="{{ old('fecha_pago', now()->format('Y-m-d\TH:i')) }}" 
                                    :readonly="!modificarFecha"
                                    :class="modificarFecha ? 'bg-white border-slate-300 text-slate-900' : 'bg-slate-100 border-transparent text-slate-500 cursor-not-allowed focus:ring-0'"
                                    class="block w-full rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                >
                                <p x-show="!modificarFecha" class="mt-2 text-xs text-slate-400">El pago se registrará con la fecha y hora actuales por seguridad.</p>
                                <p x-show="modificarFecha" x-cloak class="mt-2 text-xs text-amber-600 font-medium">⚠️ Estás alterando la fecha original del cobro.</p>
                            </div>

                            <!-- Botón de Cobro Final -->
                            <div class="pt-4">
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-8 py-4 text-lg font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.768 0-1.536-.219-2.121-.659-1.172-.879-1.172-2.303 0-3.182 1.171-.879 3.07-.879 4.242 0l.415.311M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    Confirmar y Registrar Pago
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>