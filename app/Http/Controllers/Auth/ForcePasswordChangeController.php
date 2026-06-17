<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccionAuditoria;
use App\Http\Controllers\Controller;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ForcePasswordChangeController extends Controller
{
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Muestra la pantalla obligatoria de cambio de contraseña.
     */
    public function show(): View
    {
        return view('auth.force-change-password');
    }

    /**
     * Guarda la nueva contraseña y marca la cuenta como actualizada.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        $usuario = $request->user();

        $usuario->forceFill([
            'password' => Hash::make($validated['password']),
            'password_cambiado' => true,
            'remember_token' => Str::random(60),
        ])->save();

        $this->auditoriaService->registrar(
            operador: $usuario,
            accion: AccionAuditoria::EDICION,
            modulo: 'autenticacion',
            valoresNuevos: [
                'evento' => 'cambio_obligatorio_password',
            ],
            direccionIp: $request->ip(),
        );

        Auth::logoutOtherDevices($validated['password']);

        return redirect()->route('dashboard')->with('success', 'Contraseña actualizada correctamente.');
    }
}
