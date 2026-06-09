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
                    
                    <article class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Socios Activos</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.941 3.199.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a5.971 5.971 0 0 0-.941 3.197m0 0a9.094 9.094 0 0 1-3.741-.479 3 3 0 0 1 4.682-2.72M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">{{ $sociosActivos }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs leading-5 text-slate-300">Membresías al día</p>
                    </article>

                    @can('viewFinancialReport')
                    <article class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Ingresos del Mes</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.768 0-1.536-.219-2.121-.659-1.172-.879-1.172-2.303 0-3.182 1.171-.879 3.07-.879 4.242 0l.415.311M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">$ {{ number_format($ingresosMes, 0, ',', '.') }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs leading-5 text-slate-300">Acumulado mensual.</p>
                    </article>
                    @endcan

                    <article class="flex flex-col justify-between h-full rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-md">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm text-blue-100 whitespace-nowrap">Vencimientos del día</p>
                            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5m-18 0A2.25 2.25 0 0 1 4.5 6h15a2.25 2.25 0 0 1 2.25 2.25v11.25A2.25 2.25 0 0 1 19.5 21h-15a2.25 2.25 0 0 1-2.25-2.25V8.25Zm14.25 5.25h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm-3-3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-white whitespace-nowrap">{{ $vencenHoy }}</p>
                        <div class="flex-grow"></div>
                        <p class="mt-3 text-xs font-medium leading-5 text-rose-400 whitespace-nowrap">{{ $cuotasAtrasadas }} Socios con deudas.</p>
                    </article>

                </div>
            </div>
        </div>
    </section>

    <div class="w-full bg-slate-100 py-10 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                
                @can('update', App\Models\User::class)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Sistema</p>
                                <h3 class="mt-1.5 text-lg font-semibold text-slate-900">Gestión de Usuarios</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Accesos</span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Administra los accesos al sistema. Crea cuentas para tu personal y controla sus permisos.
                        </p>
                        <div class="mt-5 space-y-2.5">
                            <a href="{{ route('usuarios.create') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Nuevo usuario
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Gestionar usuarios
                            </a>
                        </div>
                    </article>
                @endcan

                @can('viewAny', App\Models\Cliente::class)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Recepción</p>
                                <h3 class="mt-1.5 text-lg font-semibold text-slate-900">Gestión de Clientes</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Socios</span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Registra a los socios del gimnasio, mantén su información actualizada y revisa su historial.
                        </p>
                        <div class="mt-5 space-y-2.5">
                            <a href="{{ route('clientes.create') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Nuevo cliente
                            </a>
                            <a href="{{ route('clientes.index') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Gestionar clientes
                            </a>
                        </div>
                    </article>
                @endcan

                @can('create', App\Models\Membresia::class)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Comercial</p>
                                <h3 class="mt-1.5 text-lg font-semibold text-slate-900">Administrar Planes</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Planes</span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Crea y configura los planes del gimnasio. Define tarifas, duraciones y controla su disponibilidad.
                        </p>
                        <div class="mt-5 space-y-2.5">
                            <a href="{{ route('membresias.create') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Nueva membresía
                            </a>
                            <a href="{{ route('membresias.index') }}" class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Gestionar membresías
                            </a>
                        </div>
                    </article>
                @endcan

                @can('create', App\Models\Pago::class)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Caja</p>
                                <h3 class="mt-1.5 text-lg font-semibold text-slate-900">Registrar Pago</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Ingresos</span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Registra los pagos de los clientes para mantener sus membresías al día.
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('pagos.create') }}" class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Nuevo Cobro
                            </a>
                        </div>
                    </article>
                @endcan

                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:col-span-2 xl:col-span-2">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Gerencia</p>
                            <h3 class="mt-1.5 text-lg font-semibold text-slate-900">Reportes y Estadísticas</h3>
                        </div>
                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Análisis</span>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">
                        Visualiza el estado financiero del gimnasio y haz un seguimiento de la asistencia y pagos de los clientes.
                    </p>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        @can('viewActiveClientsReport')
                            <a href="{{ route('informes.clientes_vigentes') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Reporte de Socios Vigentes
                            </a>
                        @endcan

                        @can('viewOverdueClientsReport')
                            <a href="{{ route('informes.clientes_deudores') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Reporte de Socios Deudores
                            </a>
                        @endcan

                        @can('viewFinancialReport')
                            <a href="{{ route('informes.financiero') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 text-center transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Reporte Financiero
                            </a>
                        @endcan
                    </div>
                </article>

            </section>
        </div>
    </div>
@endsection