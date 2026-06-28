<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccionAuditoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $usuario = Auth::user();

        if ($usuario instanceof User) {
            $this->auditoriaService->registrar(
                operador: $usuario,
                accion: AccionAuditoria::INICIO_SESION,
                modulo: 'autenticacion',
                valoresNuevos: ['evento' => 'inicio_sesion', 'email' => $usuario->email],
                direccionIp: $request->ip(),
            );
        }

        if ($usuario instanceof User && ! $usuario->password_cambiado) {
            return redirect()->route('password.force-change');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $usuario = Auth::user();

        if ($usuario instanceof User) {
            $this->auditoriaService->registrar(
                operador: $usuario,
                // ACÁ ESTÁ EL CAMBIO CLAVE: Usamos el nuevo Enum
                accion: AccionAuditoria::CIERRE_SESION,
                modulo: 'autenticacion',
                auditable: $usuario,
                direccionIp: $request->ip(),
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
