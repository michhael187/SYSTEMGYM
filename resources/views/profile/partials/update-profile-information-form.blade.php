<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informacion del perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Estos datos se muestran como referencia. Si necesitas corregirlos, debe hacerlo un administrador desde la gestion de usuarios.
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="nombre_lectura" :value="'Nombre'" />
            <x-text-input
                id="nombre_lectura"
                type="text"
                class="mt-1 block w-full bg-gray-50 text-gray-600"
                :value="$user->nombre . ' ' . $user->apellido"
                readonly
            />
        </div>

        <div>
            <x-input-label for="email_lectura" :value="'Email'" />
            <x-text-input
                id="email_lectura"
                type="email"
                class="mt-1 block w-full bg-gray-50 text-gray-600"
                :value="$user->email"
                readonly
            />
        </div>
    </div>
</section>
