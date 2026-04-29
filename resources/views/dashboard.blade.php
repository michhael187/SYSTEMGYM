@extends('layouts.app')

@section('title', 'Dashboard | SystemGym')

@section('header')
    <div class="flex flex-col gap-2">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-600">Menu principal</p>
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">
            Panel de control de SystemGym
        </h1>
        <p class="max-w-3xl text-sm text-slate-500">
            Navega las funciones principales del sistema desde un unico lugar, con accesos organizados segun tus permisos.
        </p>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <section class="overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 shadow-sm">
                <div class="grid gap-8 px-8 py-10 lg:grid-cols-[1.5fr_0.8fr] lg:px-10">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-200">Bienvenido</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                        </h2>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-200">
                            Esta base ya te permite operar usuarios, socios, membresias, pagos e informes sin depender de rutas manuales. El panel esta pensado para que el trabajo diario sea mas directo y ordenado.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-white">
                                Rol actual: {{ ucfirst(Auth::user()->rol) }}
                            </span>

                            @if (Auth::user()->autorizado_financiero)
                                <span class="rounded-full border border-emerald-300/20 bg-emerald-400/10 px-4 py-2 text-sm text-emerald-100">
                                    Acceso financiero habilitado
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm text-blue-100">Socios</p>
                            <p class="mt-2 text-2xl font-semibold text-white">Gestion centralizada</p>
                            <p class="mt-2 text-xs leading-6 text-slate-200">Altas, busquedas y actualizaciones en un flujo mas claro.</p>
                        </article>

                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm text-blue-100">Pagos</p>
                            <p class="mt-2 text-2xl font-semibold text-white">Vigencia automatica</p>
                            <p class="mt-2 text-xs leading-6 text-slate-200">El monto y el vencimiento se calculan con reglas del sistema.</p>
                        </article>

                        <article class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                            <p class="text-sm text-blue-100">Informes</p>
                            <p class="mt-2 text-2xl font-semibold text-white">Control operativo</p>
                            <p class="mt-2 text-xs leading-6 text-slate-200">Reportes vigentes, deudores y financieros en un mismo modulo.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @can('update', App\Models\User::class)
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Modulo</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-900">Gestion de Usuarios</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Accesos</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Crea usuarios nuevos, consulta cuentas existentes y administra bajas o reactivaciones.
                        </p>
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('usuarios.create') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Instanciar nuevo usuario
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Ver / Modificar / Baja
                            </a>
                            <a href="{{ route('usuarios.reactivar.form') }}" class="block rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100">
                                Reactivar usuario
                            </a>
                        </div>
                    </article>
                @endcan

                @can('viewAny', App\Models\Cliente::class)
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Modulo</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-900">Gestion de Clientes</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Socios</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Registra clientes, consulta su informacion y accede al flujo de edicion desde una sola entrada.
                        </p>
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('clientes.create') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Registro de Clientes
                            </a>
                            <a href="{{ route('clientes.buscar.form') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Ver / Modificar Clientes
                            </a>
                        </div>
                    </article>
                @endcan

                @can('create', App\Models\Membresia::class)
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Modulo</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-900">Gestion de Membresias</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Planes</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Administra las membresias disponibles, sus precios, duracion y estado operativo.
                        </p>
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('membresias.create') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Dar alta nueva membresia
                            </a>
                            <a href="{{ route('membresias.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Modificar / Baja / Reactivar
                            </a>
                        </div>
                    </article>
                @endcan

                @can('create', App\Models\Pago::class)
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Operacion</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-900">Registrar Pago</h3>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Caja</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Busca al cliente, selecciona la membresia y confirma el pago con actualizacion automatica de vigencia.
                        </p>
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('pagos.create') }}" class="block rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Registrar nuevo pago
                            </a>
                        </div>
                    </article>
                @endcan

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:col-span-2 xl:col-span-2">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Reportes</p>
                            <h3 class="mt-2 text-xl font-semibold text-slate-900">Informes del sistema</h3>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Analisis</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Consulta los reportes operativos y financieros segun las capacidades del usuario autenticado.
                    </p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        @can('viewActiveClientsReport')
                            <a href="{{ route('informes.clientes_vigentes') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Informe de Clientes Activos
                            </a>
                        @endcan

                        @can('viewOverdueClientsReport')
                            <a href="{{ route('informes.clientes_deudores') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Informe de Clientes Activos que no pagan
                            </a>
                        @endcan

                        @can('viewFinancialReport')
                            <a href="{{ route('informes.financiero') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                Informe Financiero
                            </a>
                        @endcan
                    </div>
                </article>
            </section>
        </div>
    </div>
@endsection
