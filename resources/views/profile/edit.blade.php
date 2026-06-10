<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Mi Cuenta y Configuración
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-10 sm:px-6 lg:px-8">
            
            <div class="md:grid md:grid-cols-3 md:gap-8">
                <div class="md:col-span-1 pb-4 md:pb-0">
                    <h3 class="text-lg font-bold text-slate-900">Información del Perfil</h3>
                    <p class="mt-1 text-sm text-slate-500 leading-relaxed">
                        Actualiza la información básica de tu cuenta y dirección de correo electrónico.
                    </p>
                </div>
                
                <div class="md:col-span-2">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="hidden md:block border-t border-slate-200"></div>

            <div class="md:grid md:grid-cols-3 md:gap-8">
                <div class="md:col-span-1 pb-4 md:pb-0">
                    <h3 class="text-lg font-bold text-slate-900">Seguridad</h3>
                    <p class="mt-1 text-sm text-slate-500 leading-relaxed">
                        Asegúrate de que tu cuenta esté protegida usando una contraseña larga y segura. Se recomienda cambiarla periódicamente.
                    </p>
                </div>
                
                <div class="md:col-span-2">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>