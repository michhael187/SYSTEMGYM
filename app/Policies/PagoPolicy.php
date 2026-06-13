<?php

namespace App\Policies;

use App\Enums\RolUsuario;
use App\Models\Pago;
use App\Models\User;

class PagoPolicy
{
    /**
     * Determina si el usuario puede registrar pagos.
     */
    private function puedeRegistrarPagos(User $user): bool
    {
        return $user->estado && in_array($user->rol, RolUsuario::operativosValues(), true);
    }

    /**
     * Solo usuarios activos con rol valido pueden registrar pagos.
     */
    public function create(User $user): bool
    {
        return $this->puedeRegistrarPagos($user);
    }

    /**
     * Determina si el usuario puede descargar el comprobante PDF de un pago.
     * Previene IDOR: el rol Cliente solo accede a documentos propios.
     */
    public function download(User $user, Pago $pago): bool
    {
        if (! $user->estado) {
            return false;
        }

        if (in_array($user->rol, RolUsuario::descargaPdfGlobalValues(), true)) {
            return true;
        }

        if ($user->rol === RolUsuario::CLIENTE->value) {
            return (int) $pago->cliente_id === (int) $user->id;
        }

        return false;
    }
}
