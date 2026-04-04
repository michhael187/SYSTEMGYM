<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactivateUserRequest;
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

        /**
     * Muestra el formulario de reactivacion de usuario.
     */
    public function showReactivarForm()
    {
        $this->authorize('update', User::class);

        return view('usuarios.reactivar');
    }

    /**
     * Procesa la reactivacion de un usuario existente.
     */
    public function reactivar(ReactivateUserRequest $request)
    {
        $this->authorize('update', User::class);

        $resultado = $this->usuarioService->reactivarUsuario($request->validated());

        return match ($resultado['accion']) {
            'reactivado' => redirect()
                ->route('usuarios.reactivar.form')
                ->with('success', 'Usuario reactivado correctamente.'),

            'ya_activo' => redirect()
                ->route('usuarios.reactivar.form')
                ->with('warning', 'El usuario ya se encuentra activo.'),

            'no_encontrado' => redirect()
                ->route('usuarios.reactivar.form')
                ->with('warning', 'No se encontro un usuario con ese DNI.'),
        };
    }

}
