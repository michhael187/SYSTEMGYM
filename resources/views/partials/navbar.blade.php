<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">SystemGym</p>
                        <p class="text-sm text-slate-600">Gestion integral del gimnasio</p>
                    </div>
                </a>

                @auth
                    <div class="hidden items-center gap-2 md:flex">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">
                            Inicio
                        </a>

                        @can('viewAny', App\Models\Cliente::class)
                            <a href="{{ route('clientes.buscar.form') }}" class="{{ request()->routeIs('clientes.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">
                                Socios
                            </a>
                        @endcan

                        @can('create', App\Models\Pago::class)
                            <a href="{{ route('pagos.create') }}" class="{{ request()->routeIs('pagos.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">
                                Pagos
                            </a>
                        @endcan

                        @if (
                            Gate::allows('viewFinancialReport') ||
                            Gate::allows('viewActiveClientsReport') ||
                            Gate::allows('viewOverdueClientsReport')
                        )
                            <a href="{{ route('informes.clientes_vigentes') }}" class="{{ request()->routeIs('informes.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">
                                Informes
                            </a>
                        @endif

                        @can('create', App\Models\Membresia::class)
                            <a href="{{ route('membresias.index') }}" class="{{ request()->routeIs('membresias.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">
                                Configuracion
                            </a>
                        @endcan
                    </div>
                @endauth
            </div>

            @auth
                <div class="hidden items-center gap-4 md:flex">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ Auth::user()->rol }}</p>
                    </div>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900">
                                <span>Cuenta</span>
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesion
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
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
        <div x-cloak :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-slate-200 bg-white md:hidden">
            <div class="space-y-1 px-4 py-4">
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Inicio</a>

                @can('viewAny', App\Models\Cliente::class)
                    <a href="{{ route('clientes.buscar.form') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Socios</a>
                @endcan

                @can('create', App\Models\Pago::class)
                    <a href="{{ route('pagos.create') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Pagos</a>
                @endcan

                @if (
                    Gate::allows('viewFinancialReport') ||
                    Gate::allows('viewActiveClientsReport') ||
                    Gate::allows('viewOverdueClientsReport')
                )
                    <a href="{{ route('informes.clientes_vigentes') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Informes</a>
                @endif

                @can('create', App\Models\Membresia::class)
                    <a href="{{ route('membresias.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Configuracion</a>
                @endcan

                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Perfil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-600 hover:bg-rose-50">
                        Cerrar sesion
                    </button>
                </form>
            </div>
        </div>
    @endauth
</nav>
