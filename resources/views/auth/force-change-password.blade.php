<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-slate-50 px-6 py-12">
        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-100">
            <div class="mb-6">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Cambio obligatorio de contraseña</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Por seguridad, debes reemplazar la contraseña temporal antes de continuar.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    Revisa los campos del formulario.
                </div>
            @endif

            <form method="POST" action="{{ route('password.force-change.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">Nueva contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="mt-1 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                        required
                        autofocus
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirmar contraseña</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="mt-1 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-500">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
