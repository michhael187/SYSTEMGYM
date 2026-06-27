@extends('layouts.app')

@section('title', 'Dashboard | SystemGym')

@section('content')
    @if (session('success') || session('error'))
        <div class="w-full bg-white px-4 py-3 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mt-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <section class="w-full bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.1fr_1fr]">
                
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-200">Bienvenido</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                        {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                        Resumen de Actividad
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <span class="rounded-full border border-slate-600 bg-slate-800/50 px-4 py-1.5 text-sm text-slate-300 backdrop-blur-sm">
                            Nivel: {{ ucfirst(auth()->user()->rol) }}
                        </span>

                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-[1fr_1.3fr_1fr]">
                    
                    <a href="{{ route('informes.clientes_vigentes') }}" class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md transition hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Socios Activos</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.941 3.199.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a5.971 5.971 0 0 0-.941 3.197m0 0a9.094 9.094 0 0 1-3.741-.479 3 3 0 0 1 4.682-2.72M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">{{ $sociosActivos }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs leading-5 text-slate-300">Membresías al día</p>
                    </a>

                    @can('viewFinancialReport')
                    <a href="{{ route('informes.financiero') }}" class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md transition hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Ingresos del Mes</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.768 0-1.536-.219-2.121-.659-1.172-.879-1.172-2.303 0-3.182 1.171-.879 3.07-.879 4.242 0l.415.311M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">$ {{ number_format($ingresosMes, 0, ',', '.') }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs leading-5 text-slate-300">Acumulado mensual.</p>
                    </a>
                    @endcan

                    <a href="{{ route('informes.clientes_deudores') }}" class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md transition hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Vencimientos del día</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5m-18 0A2.25 2.25 0 0 1 4.5 6h15a2.25 2.25 0 0 1 2.25 2.25v11.25A2.25 2.25 0 0 1 19.5 21h-15a2.25 2.25 0 0 1-2.25-2.25V8.25Zm14.25 5.25h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">{{ $vencenHoy }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs font-medium leading-5 text-rose-400 whitespace-nowrap">{{ $cuotasAtrasadas }} Socios con deudas.</p>
                    </a>

                </div>
            </div>
        </div>
    </section>

    <div class="w-full bg-slate-100/80 py-12 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                
                @can('update', App\Models\User::class)
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Accesos</span>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">Gestión de Usuarios</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                Controlá las cuentas de acceso de tu personal y administrá los permisos del sistema.
                            </p>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="{{ route('usuarios.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-900 px-3 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800">
                                ➕ Nuevo
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                📁 Gestionar
                            </a>
                        </div>
                    </div>
                @endcan

                @can('viewAny', App\Models\Cliente::class)
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Socios</span>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">Gestión de Clientes</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                Registrá nuevos socios, actualizá sus datos médicos, membresías y revisá el historial.
                            </p>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="{{ route('clientes.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-900 px-3 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800">
                                ➕ Nuevo
                            </a>
                            <a href="{{ route('clientes.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                📁 Gestionar
                            </a>
                        </div>
                    </div>
                @endcan

                @can('create', App\Models\Membresia::class)
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Planes</span>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">Planes y Membresías</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                Configurá pases mensuales, semanales o pases diarios. Definí valores y vigencias.
                            </p>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="{{ route('membresias.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-900 px-3 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800">
                                ➕ Nuevo Plan
                            </a>
                            <a href="{{ route('membresias.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                📁 Gestionar
                            </a>
                        </div>
                    </div>
                @endcan

                @can('viewAny', App\Models\RegistroAuditoria::class)
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c1.07-.013 2.008.714 2.007 1.835 0 1.093-1.032 1.875-2.007 1.835m5.801 0c1.07-.013 2.008.714 2.007 1.835 0 1.093-1.032 1.875-2.007 1.835M9 12H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25H9m3-10.5V6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 011.123-.08m5.801 0c-1.07-.013-2.008.714-2.007 1.835 0 1.093 1.032-1.875 2.007-1.835m-5.801 0c-1.07-.013-2.008.714-2.007 1.835 0 1.093 1.032 1.875 2.007 1.835" /></svg>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Trazabilidad</span>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">Registro de Auditoría</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                Consultá el historial inmutable de operaciones críticas. Todos los movimientos del personal quedan registrados permanentemente.
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('auditoria.index') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                Ver Historial Completo
                            </a>
                        </div>
                    </div>
                @endcan

                @can('create', App\Models\Pago::class)
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5m-18 0A2.25 2.25 0 003.75 6.75v9.375c0 .496.4.9.9.9h16.2c.496 0 .9-.4.9-.9V6.75a2.25 2.25 0 00-2.25-2.25M3.75 12h16.5m-13.5-3h.008v.008H6.75V9zm0 6h.008v.008H6.75V15m3-6h.008v.008h-.008V9zm0 6h.008v.008h-.008V15m3-6h.008v.008h-.008V9zm0 6h.008v.008h-.008V15m3-6h.008v.008h-.008V9zm0 6h.008v.008h-.008V15" /></svg>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Ingresos</span>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">Registrar Cobro</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                                Procesá los pagos de cuotas de tus clientes de forma inmediata y emití el comprobante.
                            </p>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('pagos.create') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-blue-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Registrar Nuevo Pago
                            </a>
                        </div>
                    </div>
                @endcan

                <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md md:col-span-2 xl:col-span-2">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0v11.25m0 0h16.5m0 0h1.5m-1.5 0V3m0 0h-1.5m1.5 0v11.25M16.5 9.75v1.5m-3-3.75v5.25m-3-2.25v3" /></svg>
                            </div>
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Auditoría</span>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-slate-900">Reportes y Estadísticas del Negocio</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">
                            Analizá el estado financiero del gimnasio, controlá las deudas de los socios y exportá listados consolidados en PDF.
                        </p>
                    </div>
                    
                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        @can('viewActiveClientsReport')
                            <a href="{{ route('informes.clientes_vigentes') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                👥 Socios Vigentes
                            </a>
                        @endcan

                        @can('viewOverdueClientsReport')
                            <a href="{{ route('informes.clientes_deudores') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                🚨 Socios Deudores
                            </a>
                        @endcan

                        @can('viewFinancialReport')
                            <a href="{{ route('informes.financiero') }}" class="inline-flex items-center justify-center rounded-xl border border-blue-200 bg-blue-50/50 px-3 py-2.5 text-xs font-bold text-blue-700 shadow-sm transition hover:bg-blue-100/70">
                                💰 Balance Financiero
                            </a>
                        @endcan
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection
