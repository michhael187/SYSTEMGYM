<?php

namespace App\Enums;

enum AccionAuditoria: string
{
    case CREACION = 'creacion';
    case EDICION = 'edicion';
    case ELIMINACION = 'eliminacion'; // Corregido el typo "elimacion"
    case INICIO_SESION = 'inicio_sesion';
    case CIERRE_SESION = 'cierre_sesion';
    case LOGIN_FALLIDO = 'login_fallido';
    case DESCARGA_PDF = 'descarga_pdf';

    public function etiqueta(): string
    {
        return match ($this) {
            self::CREACION => 'Creación',
            self::EDICION => 'Edición',
            self::ELIMINACION => 'Eliminación',
            self::INICIO_SESION => 'Inicio de sesión',
            self::CIERRE_SESION => 'Cierre de sesión',
            self::LOGIN_FALLIDO => 'Login fallido',
            self::DESCARGA_PDF => 'Descarga PDF',
        };
    }
}