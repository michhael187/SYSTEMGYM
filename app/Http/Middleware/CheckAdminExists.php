<?php

namespace App\Http\Middleware;

use App\Enums\RolUsuario;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminExists
{
    /**
     * Fuerza el flujo de configuracion inicial mientras no exista un administrador.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminExiste = User::query()
            ->where('rol', RolUsuario::ADMINISTRADOR->value)
            ->exists();

        if (! $adminExiste && ! $request->routeIs('setup.*')) {
            return redirect()->route('setup.index');
        }

        if ($adminExiste && $request->routeIs('setup.*')) {
            return $request->user()
                ? redirect()->route('dashboard')
                : redirect()->route('login');
        }

        return $next($request);
    }
}
