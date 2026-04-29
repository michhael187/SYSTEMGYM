<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupAdminRequest;
use App\Services\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function __construct(private UsuarioService $usuarioService)
    {
    }

    /**
     * Muestra el formulario de configuracion inicial del sistema.
     */
    public function index(): View
    {
        return view('setup.index');
    }

    /**
     * Crea el primer administrador del sistema.
     */
    public function store(SetupAdminRequest $request): RedirectResponse
    {
        $this->usuarioService->crearAdministradorInicial($request->validated());

        return redirect()
            ->route('login')
            ->with('success', 'Administrador inicial creado correctamente. Ya puedes iniciar sesion.');
    }
}
