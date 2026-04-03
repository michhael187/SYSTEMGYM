<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    public function __construct(private UsuarioService $usuarioService)
    {
    }

    /**
     * Muestra el formulario de alta de usuario.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('usuarios.create');
    }

    /**
     * Procesa el alta de un nuevo usuario.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $this->usuarioService->crearUsuario($request->validated());

        return redirect()
            ->route('usuarios.create')
            ->with('success', 'Usuario creado correctamente.');
    }
}
