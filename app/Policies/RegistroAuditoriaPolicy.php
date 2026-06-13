<?php

namespace App\Policies;

use App\Enums\RolUsuario;
use App\Models\RegistroAuditoria;
use App\Models\User;

class RegistroAuditoriaPolicy
{
    /**
     * Solo el administrador activo puede consultar el registro de auditoría.
     */
    public function viewAny(User $user): bool
    {
        return $user->rol === RolUsuario::ADMINISTRADOR->value && $user->estado;
    }

    /**
     * Prohibido explícitamente: el historial es de solo lectura.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Prohibido explícitamente: el historial es de solo lectura.
     */
    public function update(User $user, RegistroAuditoria $registroAuditoria): bool
    {
        return false;
    }

    /**
     * Prohibido explícitamente: el historial es de solo lectura.
     */
    public function delete(User $user, RegistroAuditoria $registroAuditoria): bool
    {
        return false;
    }
}
