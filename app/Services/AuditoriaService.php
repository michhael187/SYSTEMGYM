<?php

namespace App\Services;

use App\Enums\AccionAuditoria;
use App\Models\RegistroAuditoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AuditoriaService
{
    // Le agregamos el signo de interrogación a ?User
    public function registrar(
        ?User $operador, 
        AccionAuditoria $accion,
        string $modulo,
        ?Model $auditable = null,
        ?array $valoresViejos = null,
        ?array $valoresNuevos = null,
        ?string $direccionIp = null,
    ): RegistroAuditoria {
        return RegistroAuditoria::create([
            'user_id' => $operador?->id, // Agregamos el ? antes de la flecha
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id' => $auditable?->getKey(),
            'accion' => $accion,
            'modulo' => $modulo,
            'valores_viejos' => $this->sanitizarValores($valoresViejos),
            'valores_nuevos' => $this->sanitizarValores($valoresNuevos),
            'direccion_ip' => $direccionIp ?? '0.0.0.0',
        ]);
    }

    /**
     * Elimina datos sensibles antes de persistir el snapshot en JSON.
     *
     * @param  array<string, mixed>|null  $valores
     * @return array<string, mixed>|null
     */
    private function sanitizarValores(?array $valores): ?array
    {
        if ($valores === null) {
            return null;
        }

        return Arr::except($valores, [
            'password',
            'remember_token',
        ]);
    }
    
}
