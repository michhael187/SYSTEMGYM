<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // INSERTAR AQUÍ: si el correo no existe o pertenece a una cuenta inactiva,
        // devolvemos la misma respuesta genérica para evitar enumeración de cuentas.
        $usuario = User::query()
            ->where('email', $request->string('email'))
            ->first();

        if (! $usuario || ! $usuario->estado) {
            return back()->with('status', __(Password::RESET_LINK_SENT));
        }

        // Si la cuenta existe y está activa, enviamos el enlace de recuperación
        // usando el broker nativo de Laravel.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
