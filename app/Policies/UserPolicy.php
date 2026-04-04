<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Solo un administrador puede dar de alta usuarios del sistema.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Solo un administrador puede modificar o reactivar usuarios.
     */
    public function update(User $user): bool
    {
        return $user->rol === 'administrador';
    }
}
