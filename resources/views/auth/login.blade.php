<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        
        <div class="relative hidden w-0 flex-1 bg-gradient-to-tr from-slate-950 via-slate-900 to-blue-950 lg:block">
            <div class="flex h-full flex-col justify-between p-12 z-10 relative">
                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-500/30">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                    </div>
                    <span class="text-xl font-black tracking-wider text-white">SYSTEM<span class="text-blue-500">GYM</span></span>
                </div>

                <div class="max-w-md space-y-4">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white leading-tight">
                        El control total de tu gimnasio, sin fricciones.
                    </h1>
                    <p class="text-base text-slate-400">
                        Monitoreá membresías vigentes, automatizá alertas de deudores y gestioná cierres de caja diarios, mensuales o por el rango de fechas que vos decidas.
                    </p>
                </div>

                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} SystemGym. Gestión integral de instalaciones deportivas.
                </p>
            </div>

            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
        </div>

        <div class="flex flex-1 flex-col justify-center px-6 py-12 sm:px-12 lg:flex-none lg:px-20 xl:px-24 bg-slate-50/50">
            <div class="mx-auto w-full max-w-sm lg:w-96 bg-white p-8 rounded-2xl border border-slate-200 shadow-xl shadow-slate-100">
                
                <div class="mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">¡Hola de nuevo!</h2>
                    <p class="mt-2 text-sm text-slate-500">Ingresa tus credenciales para acceder al panel de control.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if (session('success'))
                    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Correo Electrónico</label>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="tu@correo.com"
                                class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                required 
                                autofocus 
                                autocomplete="username" 
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-medium text-rose-600" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-semibold text-blue-600 hover:text-blue-500 transition" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu clave?
                                </a>
                            @endif
                        </div>
                        <div class="mt-1.5 relative rounded-md shadow-sm">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                placeholder="••••••••"
                                class="block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" 
                                required 
                                autocomplete="current-password" 
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-medium text-rose-600" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 shadow-sm"
                            >
                            <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600 select-none">
                                Recordarme en este equipo
                            </label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>