<?php

namespace App\Policies;

use App\Enums\RolUsuario;
use App\Models\User;

class UserPolicy
{
    /**
     * Solo un administrador puede listar usuarios para gestion.
     */
    public function viewAny(User $user): bool
    {
        return $user->rol === RolUsuario::ADMINISTRADOR->value && $user->estado;
    }

    /**
     * Solo un administrador puede dar de alta usuarios del sistema.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Solo un administrador puede modificar o reactivar usuarios.
     */
    public function update(User $user, ?User $targetUser = null): bool
    {
        return $this->viewAny($user);
    }
}
