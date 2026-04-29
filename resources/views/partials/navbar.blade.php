<nav x-data="{ open: false, informesOpen: false, cuentaOpen: false }" class="relative z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[4.5rem] items-center justify-between gap-6 py-3">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">SystemGym</p>
                        <p class="text-xs text-gray-500">Gesti&oacute;n integral del gimnasio</p>
                    </div>
                </a>

                @auth
                    <div class="hidden items-center gap-2 lg:flex">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                            Inicio
                        </a>

                        @can('viewAny', App\Models\Cliente::class)
                            <a href="{{ route('clientes.buscar.form') }}" class="{{ request()->routeIs('clientes.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                                Clientes
                            </a>
                        @endcan

                        @can('create', App\Models\Pago::class)
                            <a href="{{ route('pagos.create') }}" class="{{ request()->routeIs('pagos.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                                Pagos
                            </a>
                        @endcan

                        @if (
                            Gate::allows('viewFinancialReport') ||
                            Gate::allows('viewActiveClientsReport') ||
                            Gate::allows('viewOverdueClientsReport')
                        )
                            <div class="relative" x-on:click.away="informesOpen = false">
                                <button
                                    type="button"
                                    x-on:click="informesOpen = ! informesOpen; cuentaOpen = false"
                                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition"
                                    :class="informesOpen || {{ request()->routeIs('informes.*') ? 'true' : 'false' }} ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                                >
                                    <span>Informes</span>
                                    <svg class="h-4 w-4 transition" :class="{ 'rotate-180': informesOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div
                                    x-cloak
                                    x-show="informesOpen"
                                    x-transition.origin.top.left
                                    class="absolute left-0 top-full z-50 mt-3 w-72 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg"
                                >
                                    @can('viewFinancialReport')
                                        <a href="{{ route('informes.financiero') }}" class="block rounded-xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-blue-700">
                                            <span class="block font-medium">Informe Financiero</span>
                                            <span class="mt-1 block text-xs text-slate-500">Resumen financiero y recaudaci&oacute;n.</span>
                                        </a>
                                    @endcan

                                    @can('viewActiveClientsReport')
                                        <a href="{{ route('informes.clientes_vigentes') }}" class="block rounded-xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-blue-700">
                                            <span class="block font-medium">Clientes Vigentes</span>
                                            <span class="mt-1 block text-xs text-slate-500">Listado de clientes activos con vigencia actual.</span>
                                        </a>
                                    @endcan

                                    @can('viewOverdueClientsReport')
                                        <a href="{{ route('informes.clientes_deudores') }}" class="block rounded-xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-blue-700">
                                            <span class="block font-medium">Clientes Deudores</span>
                                            <span class="mt-1 block text-xs text-slate-500">Clientes activos con membres&iacute;a vencida.</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @can('create', App\Models\Membresia::class)
                            <a href="{{ route('membresias.index') }}" class="{{ request()->routeIs('membresias.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2 text-sm font-medium transition">
                                Configuraci&oacute;n
                            </a>
                        @endcan
                    </div>
                @endauth
            </div>

            @auth
                <div class="hidden items-center gap-4 lg:flex">
                    <div class="text-right leading-tight">
                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ Auth::user()->rol }}</p>
                    </div>

                    <div class="relative" x-on:click.away="cuentaOpen = false">
                        <button
                            type="button"
                            x-on:click="cuentaOpen = ! cuentaOpen; informesOpen = false"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900"
                            :class="cuentaOpen ? 'border-slate-300 text-slate-900' : ''"
                        >
                            <span>Cuenta</span>
                            <svg class="h-4 w-4 transition" :class="{ 'rotate-180': cuentaOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            x-cloak
                            x-show="cuentaOpen"
                            x-transition.origin.top.right
                            class="absolute right-0 top-full z-50 mt-3 w-60 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg"
                        >
                            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-blue-700">
                                Perfil
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full rounded-xl px-4 py-3 text-left text-sm text-rose-600 transition hover:bg-rose-50">
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
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Inicio</a>

                @can('viewAny', App\Models\Cliente::class)
                    <a href="{{ route('clientes.buscar.form') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Clientes</a>
                @endcan

                @can('create', App\Models\Pago::class)
                    <a href="{{ route('pagos.create') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Pagos</a>
                @endcan

                @if (
                    Gate::allows('viewFinancialReport') ||
                    Gate::allows('viewActiveClientsReport') ||
                    Gate::allows('viewOverdueClientsReport')
                )
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2">
                        <p class="px-2 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Informes</p>

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

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2">
                    <p class="px-2 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Cuenta</p>
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
