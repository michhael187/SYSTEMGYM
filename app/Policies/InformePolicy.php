<?php

namespace App\Policies;

use App\Enums\RolUsuario;
use App\Models\User;

class InformePolicy
{
    /**
     * Determina si el usuario puede ver informes operativos de clientes.
     */
    private function puedeVerInformesDeClientes(User $user): bool
    {
        return $user->estado && in_array($user->rol, RolUsuario::operativosValues(), true);
    }

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
        return $this->puedeVerInformesDeClientes($user);
    }

    /**
     * Solo usuarios activos con rol valido pueden ver el informe de clientes deudores.
     */
    public function viewOverdueClients(User $user): bool
    {
        return $this->puedeVerInformesDeClientes($user);
    }
}
