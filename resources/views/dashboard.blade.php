<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Menu Principal
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 rounded-2xl border border-slate-800 bg-slate-900 p-8 text-slate-100 shadow-xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-300">SystemGym</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-lg border border-slate-500 bg-black px-4 py-2 text-sm font-medium text-white hover:bg-slate-800"
                        >
                            Cerrar sesion
                        </button>
                    </form>
                </div>
                <h1 class="mt-3 text-3xl font-semibold text-white">
                    Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                </h1>
                <p class="mt-3 max-w-3xl text-sm text-slate-200">
                    Desde este panel podés navegar las funciones principales del sistema sin escribir rutas manualmente.
                </p>
                <div class="mt-4 inline-flex rounded-full border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-slate-100">
                    Rol actual: {{ ucfirst(Auth::user()->rol) }}
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @can('update', App\Models\User::class)
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-slate-800">Gestion de Usuarios</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Administra altas, consulta, modificacion, baja y reactivacion de usuarios.
                        </p>
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('usuarios.create') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Instanciar nuevo usuario
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Ver / Modificar / Baja
                            </a>
                            <a href="{{ route('usuarios.reactivar.form') }}" class="rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-center text-sm font-medium text-emerald-700">
                                Reactivar usuario
                            </a>
                        </div>
                    </section>
                @endcan

                @can('viewAny', App\Models\Cliente::class)
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-slate-800">Gestion de Clientes</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Registra clientes nuevos y accede al flujo de ver o modificar clientes ya cargados.
                        </p>
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('clientes.create') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Registro de Clientes
                            </a>
                            <a href="{{ route('clientes.buscar.form') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Ver / Modificar Clientes
                            </a>
                        </div>
                    </section>
                @endcan

                @can('create', App\Models\Membresia::class)
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-slate-800">Gestion de Membresias</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Da de alta planes nuevos y entra al listado para editar, dar de baja o reactivar membresias.
                        </p>
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('membresias.create') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Dar alta nueva membresia
                            </a>
                            <a href="{{ route('membresias.index') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Modificar / Baja / Reactivar
                            </a>
                        </div>
                    </section>
                @endcan

                @can('create', App\Models\Pago::class)
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-slate-800">Registrar Pago</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Busca el cliente, selecciona la membresia y registra el pago con actualizacion de vigencia.
                        </p>
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('pagos.create') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Registrar Nuevo Pago
                            </a>
                        </div>
                    </section>
                @endcan

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:col-span-2 xl:col-span-3">
                    <h3 class="text-xl font-semibold text-slate-800">Informes</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Accede a los reportes operativos y financieros segun los permisos del rol actual.
                    </p>
                    <div class="mt-6 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                        @can('viewActiveClientsReport')
                            <a href="{{ route('informes.clientes_vigentes') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Informe de Clientes Activos
                            </a>
                        @endcan

                        @can('viewOverdueClientsReport')
                            <a href="{{ route('informes.clientes_deudores') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Informe de Clientes Activos que no pagan
                            </a>
                        @endcan

                        @can('viewFinancialReport')
                            <a href="{{ route('informes.financiero') }}" class="rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700">
                                Informe Financiero
                            </a>
                        @endcan
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
