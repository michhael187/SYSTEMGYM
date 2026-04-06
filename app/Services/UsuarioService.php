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

    /**
     * Reactiva un usuario existente a partir de su DNI.
     */
    public function reactivarUsuario(array $datos): array
    {
        $usuario = User::where('dni', $datos['dni'])->first();

        if (! $usuario) {
            return [
                'accion' => 'no_encontrado',
                'usuario' => null,
            ];
        }

        if ($usuario->estado) {
            return [
                'accion' => 'ya_activo',
                'usuario' => $usuario,
            ];
        }

        $usuario->update([
            'password' => $datos['password'],
            'password_cambiado' => false,
            'autorizado_financiero' => $this->determinarAutorizacionFinanciera($usuario->rol),
            'estado' => true,
        ]);

        return [
            'accion' => 'reactivado',
            'usuario' => $usuario->fresh(),
        ];
    }

    /**
     * Actualiza los datos editables de un usuario existente.
     */
    public function actualizarUsuario(User $usuario, array $datos): User
    {
        $usuario->update([
            'rol' => $datos['rol'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'autorizado_financiero' => $this->determinarAutorizacionFinanciera($datos['rol']),
            'estado' => $datos['estado'],
        ]);

        return $usuario->fresh();
    }

}
