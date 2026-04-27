<?php

namespace App\Policies;

use App\Models\Membresia;
use App\Models\User;

class MembresiaPolicy
{
    /**
     * Determina si el usuario puede administrar membresias.
     */
    private function puedeGestionarMembresias(User $user): bool
    {
        return $user->rol === 'administrador' && $user->estado;
    }

    /**
     * Solo un administrador puede listar membresias para gestion.
     */
    public function viewAny(User $user): bool
    {
        return $this->puedeGestionarMembresias($user);
    }

    /**
     * Solo un administrador puede crear membresias.
     */
    public function create(User $user): bool
    {
        return $this->puedeGestionarMembresias($user);
    }

    /**
     * Solo un administrador puede modificar, dar de baja o reactivar membresias.
     */
    public function update(User $user, ?Membresia $membresia = null): bool
    {
        return $this->puedeGestionarMembresias($user);
    }
}
