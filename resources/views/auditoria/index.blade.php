<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-slate-800">
                Registro de Auditoría
            </h2>
            <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-300 bg-slate-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-slate-600">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                Solo lectura
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    </div>
                    <div>
    <p class="text-sm font-bold text-amber-900">Registro de Actividad Protegido</p>
    <p class="mt-1 text-sm leading-relaxed text-amber-800">
        Supervise los movimientos de su personal con total garantía. Por motivos de seguridad, esta pantalla es estrictamente de <strong>solo consulta</strong>. El sistema bloquea cualquier intento de ocultar, editar o eliminar el historial de acciones.
    </p>
</div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @if ($registros->count() === 0)
                    <div class="p-10 text-center text-sm font-medium text-slate-500">
                        No hay registros de auditoría disponibles.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Fecha y Hora</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Usuario Operador</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Acción Realizada</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">Módulo Afectado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($registros as $registro)
                                    <tr class="transition hover:bg-slate-50/70">
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-700">
                                            {{ $registro->created_at->format('d/m/Y H:i') }} hs
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            @if ($registro->usuario)
                                                <div class="flex items-center gap-2">
                                                    <span class="font-semibold text-slate-900">
                                                        <span class="font-semibold text-slate-900">
                                                            @if(trim($registro->usuario->apellido))
                                                                {{ trim($registro->usuario->apellido) }}, {{ trim($registro->usuario->nombre) }}
                                                            @else
                                                                {{ trim($registro->usuario->nombre) }}
                                                            @endif
                                                        </span>
                                                    </span>
                                                    
                                                    @php
                                                        $rolStr = strtolower($registro->usuario->rol);
                                                        $rolBadge = match($rolStr) {
                                                            'administrador' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                            'gerente' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                            default => 'bg-slate-50 text-slate-700 border-slate-200', // Encargado
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $rolBadge }}">
                                                        {{ $registro->usuario->rol }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-slate-400 italic">Usuario eliminado / Sistema</span>
                                            @endif
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            @php
                                                // Obtenemos el nombre de la acción (del Enum o string)
                                                $nombreAccion = is_object($registro->accion) ? $registro->accion->etiqueta() : $registro->accion;
                                                $accionLower = strtolower($nombreAccion);
                                                
                                                // Asignamos color según la palabra clave de la acción
                                                $accionStyle = match(true) {
                                                    str_contains($accionLower, 'inicio') => 'text-emerald-700 bg-emerald-50 border-emerald-200',
                                                    str_contains($accionLower, 'cierre') => 'text-amber-700 bg-amber-50 border-amber-200',
                                                    str_contains($accionLower, 'creaci') => 'text-blue-700 bg-blue-50 border-blue-200',
                                                    str_contains($accionLower, 'edici') || str_contains($accionLower, 'modific') => 'text-indigo-700 bg-indigo-50 border-indigo-200',
                                                    str_contains($accionLower, 'elimin') || str_contains($accionLower, 'baja') => 'text-rose-700 bg-rose-50 border-rose-200',
                                                    default => 'text-slate-700 bg-slate-100 border-slate-200',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-bold {{ $accionStyle }}">
                                                {{ $nombreAccion }}
                                            </span>
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-600">
                                            {{ method_exists($registro, 'moduloEtiqueta') ? $registro->moduloEtiqueta() : $registro->auditable_type }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div>
                {{ $registros->links() }}
            </div>
        </div>
    </div>
</x-app-layout>