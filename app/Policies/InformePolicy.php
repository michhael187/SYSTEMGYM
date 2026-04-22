<?php

namespace App\Policies;

use App\Models\User;

class InformePolicy
{
    /**
     * Solo usuarios activos con permiso financiero pueden ver el informe financiero.
     */
    public function viewFinancial(User $user): bool
    {
        return $user->estado && $user->autorizado_financiero;
    }
}