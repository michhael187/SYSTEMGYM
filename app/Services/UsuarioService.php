<?php

namespace App\Services;

use App\Models\User;

class UsuarioService
{
    /**
     * Crea un nuevo usuario del sistema.
     */
    public function crearUsuario(array $datos): User
    {
        $autorizadoFinanciero = $this->determinarAutorizacionFinanciera($datos['rol']);

        return User::create([
            'rol' => $datos['rol'],
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'password' => $datos['password'],
            'password_cambiado' => false,
            'autorizado_financiero' => $autorizadoFinanciero,
            'estado' => $datos['estado'],
        ]);
    }

    /**
     * Define si el rol puede acceder a informacion financiera.
     */
    private function determinarAutorizacionFinanciera(string $rol): bool
    {
        return $rol === 'gerente';
    }
}
