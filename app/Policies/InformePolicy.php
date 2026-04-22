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

    /**
     * Solo usuarios activos con rol valido pueden ver el informe de clientes vigentes.
     */
    public function viewActiveClients(User $user): bool
    {
        return $user->estado && in_array($user->rol, [
            'administrador',
            'gerente',
            'encargado',
        ]);
    }
}
