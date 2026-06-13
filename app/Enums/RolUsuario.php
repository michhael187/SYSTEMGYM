<?php

namespace App\Enums;

enum RolUsuario: string
{
    case ADMINISTRADOR = 'administrador';
    case GERENTE = 'gerente';
    case ENCARGADO = 'encargado';
    case CLIENTE = 'cliente';

    /**
     * Valores permitidos para validacion de formularios de alta/edicion.
     *
     * @return list<string>
     */
    public static function gestionablesValues(): array
    {
        return [
            self::GERENTE->value,
            self::ENCARGADO->value,
        ];
    }

    /**
     * Roles habilitados para operacion general del sistema.
     *
     * @return list<string>
     */
    public static function operativosValues(): array
    {
        return [
            self::ADMINISTRADOR->value,
            self::GERENTE->value,
            self::ENCARGADO->value,
        ];
    }

    /**
     * Roles con acceso global a documentos PDF del sistema.
     *
     * @return list<string>
     */
    public static function descargaPdfGlobalValues(): array
    {
        return [
            self::ADMINISTRADOR->value,
            self::GERENTE->value,
        ];
    }
}
