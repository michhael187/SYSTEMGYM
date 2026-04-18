<?php

namespace App\Policies;

use App\Models\Pago;
use App\Models\User;

class PagoPolicy
{
    /**
     * Solo usuarios activos con rol valido pueden registrar pagos.
     */
    public function create(User $user): bool
    {
        return $user->estado && in_array($user->rol, [
            'administrador',
            'gerente',
            'encargado',
        ]);
    }
}
