<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordChanged
{
    /**
     * Obliga a cambiar la contraseña temporal antes de entrar al sistema.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        if ($request->routeIs('password.force-change*', 'logout')) {
            return $next($request);
        }

        if (! (bool) $request->user()?->password_cambiado) {
            return redirect()->route('password.force-change');
        }

        return $next($request);
    }
}
