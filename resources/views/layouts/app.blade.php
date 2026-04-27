<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'SystemGym'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col">
            @include('partials.navbar')

            @if (isset($header) || $__env->hasSection('header'))
                <header class="border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        @isset($header)
                            {{ $header }}
                        @else
                            @yield('header')
                        @endisset
                    </div>
                </header>
            @endif

            <main class="flex-1">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>

            @include('partials.footer')
        </div>
    </body>
</html>
