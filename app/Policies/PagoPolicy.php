<?php

namespace App\Policies;

use App\Models\User;

class PagoPolicy
{
    /**
     * Determina si el usuario puede registrar pagos.
     */
    private function puedeRegistrarPagos(User $user): bool
    {
        return $user->estado && in_array($user->rol, [
            'administrador',
            'gerente',
            'encargado',
        ], true);
    }

    /**
     * Solo usuarios activos con rol valido pueden registrar pagos.
     */
    public function create(User $user): bool
    {
        return $this->puedeRegistrarPagos($user);
    }
}
