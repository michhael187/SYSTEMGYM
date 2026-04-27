<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ReactivateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct(private UsuarioService $usuarioService)
    {
    }

    /**
     * Muestra un listado de usuarios para acceder a editar, baja o reactivar.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $busqueda = trim((string) $request->query('buscar', ''));

        $usuarios = User::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($subQuery) use ($busqueda) {
                    $subQuery->where('nombre', 'like', '%' . $busqueda . '%')
                        ->orWhere('apellido', 'like', '%' . $busqueda . '%')
                        ->orWhere('email', 'like', '%' . $busqueda . '%')
                        ->orWhere('dni', 'like', '%' . $busqueda . '%');
                });
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('usuarios.index', compact('usuarios', 'busqueda'));
    }

    /**
     * Muestra el formulario de alta de usuario.
     */
    public function create(): View
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
    public function showReactivarForm(): View
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

     /**
     * Muestra el formulario de edicion de un usuario.
     */
    public function edit(User $usuario): View
    {
        $this->authorize('update', $usuario);

        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Procesa la modificacion de un usuario existente.
     */
    public function update(UpdateUserRequest $request, User $usuario)
    {
        $this->authorize('update', $usuario);

        $this->usuarioService->actualizarUsuario($usuario, $request->validated());

        return redirect()
            ->route('usuarios.edit', $usuario)
            ->with('success', 'Usuario actualizado correctamente.');
    }


        /**
     * Realiza la baja logica de un usuario.
     */
    public function darDeBaja(User $usuario)
    {
        $this->authorize('update', $usuario);

        $this->usuarioService->darDeBajaUsuario($usuario);

        return redirect()
            ->route('usuarios.edit', $usuario)
            ->with('success', 'Usuario dado de baja correctamente.');
    }

}
