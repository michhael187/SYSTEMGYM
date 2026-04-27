<?php

namespace App\Policies;

use App\Models\User;

class ClientePolicy
{
    /**
     * Usuarios activos habilitados para operar clientes.
     */
    public function viewAny(User $user): bool
    {
        return $user->estado && in_array($user->rol, [
            'administrador',
            'gerente',
            'encargado',
        ], true);
    }

    /**
     * Usuarios activos habilitados para alta de clientes.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Usuarios activos habilitados para edicion de clientes.
     */
    public function update(User $user): bool
    {
        return $this->viewAny($user);
    }
}
