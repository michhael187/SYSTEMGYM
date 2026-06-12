@php
    // Detectamos si el usuario es el Administrador Root del sistema
    $esAdmin = auth()->user()->rol === \App\Enums\RolUsuario::ADMINISTRADOR->value || auth()->user()->rol === 'administrador';
    
    // Capturamos el texto del rol actual para el mensaje de interfaz
    $rolActual = (string) (auth()->user()->rol->value ?? auth()->user()->rol);
@endphp

<section class="space-y-6">
    
    @if ($esAdmin)
        <div class="flex items-center gap-2 text-xs text-blue-700 bg-blue-50 p-3 rounded-lg border border-blue-100">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Privilegios de <strong>Administrador</strong> activos. Podés modificar tu nombre y apellido. El correo electrónico permanece fijo por seguridad del sistema.</span>
        </div>
    @else
        <div class="flex items-center gap-2 text-xs text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-100">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            <span>Tu cuenta está configurada con el rol de <span class="uppercase font-bold">{{ $rolActual }}</span>. Por normativas de auditoría interna, solo el Administrador general puede modificar tus datos de identidad.</span>
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700">Nombre</label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    value="{{ old('name', $user->name) }}" 
                    @disabled(!$esAdmin)
                    class="mt-1.5 block w-full rounded-lg text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500 {{ !$esAdmin ? 'border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed focus:ring-0 focus:border-slate-200' : 'border-slate-300 bg-slate-50 text-slate-900' }}" 
                    required 
                    autocomplete="given-name" 
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-medium text-rose-600" />
            </div>

            <div>
                <label for="apellido" class="block text-sm font-semibold text-slate-700">Apellido</label>
                <input 
                    id="apellido" 
                    name="apellido" 
                    type="text" 
                    value="{{ old('apellido', $user->apellido) }}" 
                    @disabled(!$esAdmin)
                    class="mt-1.5 block w-full rounded-lg text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500 {{ !$esAdmin ? 'border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed focus:ring-0 focus:border-slate-200' : 'border-slate-300 bg-slate-50 text-slate-900' }}" 
                    required 
                    autocomplete="family-name" 
                />
                <x-input-error :messages="$errors->get('apellido')" class="mt-2 text-xs font-medium text-rose-600" />
            </div>

            <div class="md:col-span-2 max-w-md">
                <label for="email" class="block text-sm font-semibold text-slate-700">Correo Electrónico / Usuario</label>
                <input 
                    id="email" 
                    type="email" 
                    value="{{ $user->email }}" 
                    disabled
                    class="mt-1.5 block w-full rounded-lg border-slate-200 bg-slate-100 text-sm text-slate-500 shadow-sm cursor-not-allowed focus:ring-0 focus:border-slate-200" 
                />
            </div>
        </div>

        @if ($esAdmin)
            <div class="flex items-center justify-between gap-4 border-t border-slate-100 pt-5">
                <div>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-emerald-600">
                            ✓ Datos de identidad actualizados correctamente.
                        </p>
                    @endif
                </div>
                
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">
                    Guardar Cambios
                </button>
            </div>
        @endif
    </form>
</section>