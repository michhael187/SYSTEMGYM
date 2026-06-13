<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Services\AuditoriaService;
use App\Enums\AccionAuditoria;

class RegistrarLoginFallido
{
    /**
     * Inyectamos el servicio igual que en los controladores
     */
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        // El $event->user puede ser null si el email no existe en la base de datos
        $this->auditoriaService->registrar(
            operador: $event->user, 
            accion: AccionAuditoria::LOGIN_FALLIDO,
            modulo: 'autenticacion',
            auditable: $event->user,
            valoresNuevos: [
                'email_intentado' => $event->credentials['email'] ?? 'desconocido',
                'alerta' => 'Intento de acceso denegado'
            ],
            direccionIp: request()->ip(),
        );
    }
}