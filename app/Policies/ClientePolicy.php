<?php

namespace App\Policies;

use App\Models\User;

class ClientePolicy
{
    /**
     * Determina si el usuario puede operar el modulo de clientes.
     */
    private function puedeGestionarClientes(User $user): bool
    {
        return $user->estado && in_array($user->rol, [
            'administrador',
            'gerente',
            'encargado',
        ], true);
    }

    /**
     * Usuarios activos habilitados para operar clientes.
     */
    public function viewAny(User $user): bool
    {
        return $this->puedeGestionarClientes($user);
    }

    /**
     * Usuarios activos habilitados para alta de clientes.
     */
    public function create(User $user): bool
    {
        return $this->puedeGestionarClientes($user);
    }

    /**
     * Usuarios activos habilitados para edicion de clientes.
     */
    public function update(User $user, ?object $target = null): bool
    {
        return $this->puedeGestionarClientes($user);
    }
}
