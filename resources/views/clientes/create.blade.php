<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Registrar Nuevo Socio
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="mb-6 space-y-4">
                @if (session('success'))
                    <div class="flex flex-col justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm sm:flex-row sm:items-center">
                        <div>
                            <p class="font-bold text-emerald-800">&iexcl;Socio registrado con &eacute;xito!</p>
                            @if (session('cliente_creado_id'))
                                <p class="mt-1 text-sm text-emerald-700">
                                    Ficha creada para: <span class="font-semibold">{{ session('cliente_creado_nombre') }}</span>.
                                </p>
                            @endif
                        </div>

                        @if (session('cliente_creado_id'))
                            <a href="{{ route('pagos.create', ['cliente_id' => session('cliente_creado_id')]) }}" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.768 0-1.536-.219-2.121-.659-1.172-.879-1.172-2.303 0-3.182 1.171-.879 3.07-.879 4.242 0l.415.311M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Registrar Primer Pago
                            </a>
                        @endif
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                        <strong class="font-bold">Revisa los siguientes errores antes de continuar:</strong>
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
                    <h3 class="text-lg font-semibold text-slate-800">Ficha del Cliente</h3>
                    <p class="text-sm text-slate-500">Ingresa los datos personales y f&iacute;sicos del nuevo socio.</p>
                </div>

                <form action="{{ route('clientes.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="nombre" class="mb-1 block text-sm font-medium text-slate-700">Nombre <span class="text-rose-500">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Juan" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido" class="mb-1 block text-sm font-medium text-slate-700">Apellido <span class="text-rose-500">*</span></label>
                            <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" placeholder="Ej: P&eacute;rez" oninput="this.value = this.value.replace(/[^\p{L}\s]/gu, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('apellido')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dni" class="mb-1 block text-sm font-medium text-slate-700">DNI <span class="text-rose-500">*</span></label>
                            <input type="text" inputmode="numeric" name="dni" id="dni" value="{{ old('dni') }}" placeholder="Ej: 35123456" oninput="this.value = this.value.replace(/\D/g, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('dni')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="mb-1 block text-sm font-medium text-slate-700">Tel&eacute;fono <span class="text-rose-500">*</span></label>
                            <input type="text" inputmode="numeric" name="telefono" id="telefono" value="{{ old('telefono') }}" placeholder="Ej: 2902456789" oninput="this.value = this.value.replace(/\D/g, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                            @error('telefono')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="my-2 border-t border-slate-100 md:col-span-2"></div>

                        <div>
                            <label for="peso" class="mb-1 block text-sm font-medium text-slate-700">Peso (kg) <span class="text-slate-400 font-normal">(Opcional)</span></label>
                            <input type="text" inputmode="decimal" name="peso" id="peso" value="{{ old('peso') }}" placeholder="Ej: 75.5" oninput="this.value = this.value.replace(/[^0-9.,]/g, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                            @error('peso')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="altura" class="mb-1 block text-sm font-medium text-slate-700">Altura (cm) <span class="text-slate-400 font-normal">(Opcional)</span></label>
                            <input type="text" inputmode="decimal" name="altura" id="altura" value="{{ old('altura') }}" placeholder="Ej: 175" oninput="this.value = this.value.replace(/[^0-9.,]/g, '')" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500">
                            @error('altura')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2" x-data="{
                            texto: @js(old('observaciones', '')),
                            insertarTag(tag) {
                                if (this.texto.length > 0 && !this.texto.endsWith(' ')) {
                                    this.texto += ' ';
                                }
                                this.texto += '[' + tag + ']: ';
                                this.$refs.textareaObs.focus();
                            }
                        }">
                            <div class="mb-1 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                                <label for="observaciones" class="text-sm font-medium text-slate-700">
                                    Observaciones M&eacute;dicas / Notas <span class="text-slate-400 font-normal">(Opcional)</span>
                                </label>

                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="mr-1 text-xs text-slate-400">Insertar atajo:</span>
                                    <button type="button" @click="insertarTag('LESI&Oacute;N')" class="inline-flex items-center rounded-md border border-amber-200 bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 transition hover:bg-amber-100">
                                        &#9888;&#65039; Lesi&oacute;n
                                    </button>
                                    <button type="button" @click="insertarTag('ENFERMEDAD')" class="inline-flex items-center rounded-md border border-rose-200 bg-rose-50 px-2 py-1 text-xs font-medium text-rose-800 transition hover:bg-rose-100">
                                        &#129658; Enfermedad
                                    </button>
                                    <button type="button" @click="insertarTag('ATENCI&Oacute;N')" class="inline-flex items-center rounded-md border border-blue-200 bg-blue-50 px-2 py-1 text-xs font-medium text-blue-800 transition hover:bg-blue-100">
                                        &#128161; Situaci&oacute;n
                                    </button>
                                </div>
                            </div>

                            <div class="relative mt-1">
                                <textarea
                                    x-ref="textareaObs"
                                    x-model="texto"
                                    name="observaciones"
                                    id="observaciones"
                                    rows="3"
                                    placeholder="Selecciona un atajo de arriba o escribe libremente los detalles m&eacute;dicos..."
                                    class="block w-full resize-none rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                                ></textarea>
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Las notas ayudan a los profesores a conocer las limitaciones f&iacute;sicas del socio.</p>
                        </div>

                        <div class="my-2 border-t border-slate-100 md:col-span-2"></div>

                        <div>
                            <label for="estado" class="mb-1 block text-sm font-medium text-slate-700">Estado del Socio <span class="text-rose-500">*</span></label>
                            <select name="estado" id="estado" class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" required>
                                <option value="1" {{ old('estado', '1') === '1' ? 'selected' : '' }}>&#x1F7E2; Activo</option>
                                <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>&#x1F534; Inactivo</option>
                            </select>
                            @error('estado')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <div class="rounded-lg border border-blue-100 bg-blue-50 p-3 text-xs leading-relaxed text-blue-700">
                                &#8505; <span class="font-semibold">Nota:</span> El plan de membres&iacute;a y el vencimiento se asignar&aacute;n autom&aacute;ticamente cuando registres el primer pago.
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                        <a href="{{ route('clientes.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                            Cancelar
                        </a>
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Registrar Socio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
