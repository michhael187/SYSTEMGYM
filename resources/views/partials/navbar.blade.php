<nav x-data="{ open: false, informesOpen: false, cuentaOpen: false }" class="relative z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[4.5rem] items-center justify-between gap-6 py-3">
            
            <div class="flex items-center gap-8">
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-800">SystemGym</p>
                        <p class="hidden md:block text-xs text-slate-500">Gesti&oacute;n integral del gimnasio</p>
                    </div>
                </a>

                @auth
                    <div class="hidden items-center gap-2 lg:flex">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                            Inicio
                        </a>

                        @can('viewAny', App\Models\Cliente::class)
                            <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                                Clientes
                            </a>
                        @endcan


                        @if (Gate::allows('viewFinancialReport') || Gate::allows('viewActiveClientsReport') || Gate::allows('viewOverdueClientsReport'))
                            <div class="relative" x-on:click.away="informesOpen = false">
                                <button type="button" x-on:click="informesOpen = ! informesOpen; cuentaOpen = false" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition" :class="informesOpen || {{ request()->routeIs('informes.*') ? 'true' : 'false' }} ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    <span>Informes</span>
                                    <svg class="h-4 w-4 transition" :class="{ 'rotate-180': informesOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-cloak x-show="informesOpen" x-transition.origin.top.left class="absolute left-0 top-full z-50 mt-3 w-80 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl ring-1 ring-slate-900/5">
                                    
                                    @can('viewFinancialReport')
                                        <a href="{{ route('informes.financiero') }}" class="flex items-start gap-3 rounded-xl p-3 transition hover:bg-blue-50">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Informe Financiero</p>
                                                <p class="mt-1 text-xs text-slate-500">Resumen de caja y recaudaci&oacute;n.</p>
                                            </div>
                                        </a>
                                    @endcan

                                    @can('viewActiveClientsReport')
                                        <a href="{{ route('informes.clientes_vigentes') }}" class="flex items-start gap-3 rounded-xl p-3 transition hover:bg-emerald-50">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Reporte de Vigentes</p>
                                                <p class="mt-1 text-xs text-slate-500">Asistencia y socios habilitados.</p>
                                            </div>
                                        </a>
                                    @endcan

                                    @can('viewOverdueClientsReport')
                                        <a href="{{ route('informes.clientes_deudores') }}" class="flex items-start gap-3 rounded-xl p-3 transition hover:bg-rose-50">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Socios Deudores</p>
                                                <p class="mt-1 text-xs text-slate-500">Seguimiento de cuotas impagas.</p>
                                            </div>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @can('create', App\Models\Membresia::class)
                            <a href="{{ route('membresias.index') }}" class="{{ request()->routeIs('membresias.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                                Planes
                            </a>
                        @endcan
                    </div>
                @endauth
            </div>

            @auth
                <div class="hidden items-center gap-4 lg:flex">
                    
                    @can('create', App\Models\Pago::class)
                        <a href="{{ route('pagos.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Nuevo Cobro
                        </a>
                        <div class="h-6 w-px bg-slate-200"></div>
                    @endcan

                    <div class="relative" x-on:click.away="cuentaOpen = false">
                        <button type="button" x-on:click="cuentaOpen = ! cuentaOpen; informesOpen = false" class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-slate-100" :class="cuentaOpen ? 'bg-slate-100' : ''">
                            
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-800 text-sm font-bold text-white shadow-sm">
                                {{ substr(Auth::user()->nombre, 0, 1) }}
                            </div>
                            
                            <div class="hidden text-left md:block">
                                <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                                <p class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">{{ Auth::user()->rol }}</p>
                            </div>
                            
                            <svg class="h-4 w-4 text-slate-400 transition" :class="{ 'rotate-180': cuentaOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-cloak x-show="cuentaOpen" x-transition.origin.top.right class="absolute right-0 top-full z-50 mt-3 w-56 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl ring-1 ring-slate-900/5">
                            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-blue-700">
                                Perfil de usuario
                            </a>
                            <div class="my-1 border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full rounded-xl px-4 py-2.5 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                                    Cerrar sesi&oacute;n
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex items-center lg:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endauth
        </div>
    </div>

    @auth
        <div x-cloak :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-slate-200 bg-white lg:hidden">
            <div class="space-y-2 px-4 py-4">
                
                @can('create', App\Models\Pago::class)
                    <a href="{{ route('pagos.create') }}" class="block rounded-xl bg-blue-50 px-4 py-3 text-center text-sm font-bold text-blue-700 hover:bg-blue-100 mb-4">
                        + Nuevo Cobro
                    </a>
                @endcan

                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Inicio</a>

                @can('viewAny', App\Models\Cliente::class)
                    <a href="{{ route('clientes.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Clientes</a>
                @endcan

                @can('create', App\Models\Pago::class)
                    <a href="{{ route('pagos.create') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Pagos</a>
                @endcan

                @if (Gate::allows('viewFinancialReport') || Gate::allows('viewActiveClientsReport') || Gate::allows('viewOverdueClientsReport'))
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-2">
                        <p class="px-2 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Informes</p>

                        @can('viewFinancialReport')
                            <a href="{{ route('informes.financiero') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-white">Informe Financiero</a>
                        @endcan

                        @can('viewActiveClientsReport')
                            <a href="{{ route('informes.clientes_vigentes') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-white">Clientes Vigentes</a>
                        @endcan

                        @can('viewOverdueClientsReport')
                            <a href="{{ route('informes.clientes_deudores') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-white">Clientes Deudores</a>
                        @endcan
                    </div>
                @endif

                @can('create', App\Models\Membresia::class)
                    <a href="{{ route('membresias.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Configuraci&oacute;n</a>
                @endcan

                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-2">
                    <div class="flex items-center gap-3 px-3 py-2 mb-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-800 text-xs font-bold text-white">
                            {{ substr(Auth::user()->nombre, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->nombre }}</p>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">{{ Auth::user()->rol }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-white">Perfil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-rose-600 hover:bg-white">
                            Cerrar sesi&oacute;n
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>