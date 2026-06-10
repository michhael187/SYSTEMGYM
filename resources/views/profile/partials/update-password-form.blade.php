<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-5">
            <div class="max-w-md">
                <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700">Contraseña Actual</label>
                <input id="update_password_current_password" name="current_password" type="password" class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" autocomplete="current-password" required />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-medium text-rose-600" />
            </div>

            <div class="max-w-md">
                <label for="update_password_password" class="block text-sm font-semibold text-slate-700">Nueva Contraseña</label>
                <input id="update_password_password" name="password" type="password" class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" autocomplete="new-password" required />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs font-medium text-rose-600" />
            </div>

            <div class="max-w-md">
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700">Confirmar Nueva Contraseña</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full rounded-lg border-slate-300 bg-slate-50 text-sm shadow-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500" autocomplete="new-password" required />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs font-medium text-rose-600" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 border-t border-slate-100 pt-5">
            <div>
                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-emerald-600">
                        ✓ Contraseña actualizada.
                    </p>
                @endif
            </div>

            <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">
                Actualizar Contraseña
            </button>
        </div>
    </form>
</section>