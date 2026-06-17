<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        <div class="relative hidden w-0 flex-1 bg-gradient-to-tr from-slate-950 via-slate-900 to-blue-950 lg:block">
            <div class="relative z-10 flex h-full flex-col justify-between p-12">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-500/30">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-wider text-white">SYSTEM<span class="text-blue-500">GYM</span></span>
                </div>

                <div class="max-w-md space-y-4">
                    <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white">
                        Recupera el acceso sin perder el ritmo.
                    </h1>
                    <p class="text-base text-slate-400">
                        Te enviaremos un enlace seguro para crear una nueva contrasena si el correo pertenece a una cuenta activa.
                    </p>
                </div>

                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} SystemGym. Gestion integral de instalaciones deportivas.
                </p>
            </div>

            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
        </div>

        <div class="flex flex-1 flex-col justify-center bg-slate-50/50 px-6 py-12 sm:px-12 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-100 lg:w-96">
                <div class="mb-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Recuperar contrasena</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Ingresa tu correo electronico y, si esta registrado, recibiras un enlace para restablecer tu contrasena.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Correo electronico</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="tu@correo.com"
                            class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                            required
                            autofocus
                            autocomplete="username"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-medium text-rose-600" />
                    </div>

                    <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Enviar enlace
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 transition hover:text-blue-500">
                            Volver al inicio de sesion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
