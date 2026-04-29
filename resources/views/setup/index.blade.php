<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Setup Inicial | SystemGym</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-2xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">SystemGym</p>
                    <h1 class="mt-3 text-3xl font-semibold text-slate-900">Registro de dueño / administrador</h1>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Este formulario se muestra solo mientras el sistema no tenga un administrador registrado.
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <strong>Se encontraron errores:</strong>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('setup.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="dni" class="block text-sm font-medium text-slate-700">DNI</label>
                        <input
                            type="number"
                            name="dni"
                            id="dni"
                            value="{{ old('dni') }}"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-slate-700">Nombre</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre') }}"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium text-slate-700">Apellido</label>
                        <input
                            type="text"
                            name="apellido"
                            id="apellido"
                            value="{{ old('apellido') }}"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmar contraseña</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm"
                        >
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                            Crear administrador inicial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
