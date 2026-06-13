<?php

namespace App\Services;

use App\Enums\AccionAuditoria;
use App\Enums\RolUsuario;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{
    public function __construct(private AuditoriaService $auditoriaService)
    {
    }

    /**
     * Crea el primer administrador del sistema durante el setup inicial.
     */
    public function crearAdministradorInicial(array $datos): User
    {
        $usuario = User::create([
            'rol' => RolUsuario::ADMINISTRADOR->value,
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'password' => $datos['password'],
            'password_cambiado' => true,
            'autorizado_financiero' => true,
            'estado' => true,
        ]);

        $this->auditoriaService->registrar(
            operador: $usuario,
            accion: AccionAuditoria::CREACION,
            modulo: 'usuarios',
            auditable: $usuario,
            valoresNuevos: $usuario->toArray(),
            direccionIp: request()->ip(),
        );

        return $usuario;
    }

    /**
     * Crea un nuevo usuario del sistema.
     */
    public function crearUsuario(array $datos): User
    {
        $autorizadoFinanciero = $this->determinarAutorizacionFinanciera($datos['rol']);

        $usuario = User::create([
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

        $this->registrarOperacion(
            AccionAuditoria::CREACION,
            $usuario,
            null,
            $usuario->toArray(),
        );

        return $usuario;
    }

    /**
     * Define si el rol puede acceder a informacion financiera.
     */
    private function determinarAutorizacionFinanciera(string $rol): bool
    {
        return RolUsuario::tryFrom($rol) === RolUsuario::GERENTE;
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

        $valoresViejos = $usuario->toArray();

        $usuario->update([
            'password' => $datos['password'],
            'password_cambiado' => false,
            'autorizado_financiero' => $this->determinarAutorizacionFinanciera($usuario->rol),
            'estado' => true,
        ]);

        $this->registrarOperacion(
            AccionAuditoria::EDICION,
            $usuario->fresh(),
            $valoresViejos,
            $usuario->fresh()->toArray(),
        );

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
        $valoresViejos = $usuario->toArray();

        $usuario->update([
            'rol' => $datos['rol'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'autorizado_financiero' => $this->determinarAutorizacionFinanciera($datos['rol']),
        ]);

        $this->registrarOperacion(
            AccionAuditoria::EDICION,
            $usuario->fresh(),
            $valoresViejos,
            $usuario->fresh()->toArray(),
        );

        return $usuario->fresh();
    }

    /**
     * Realiza la baja logica de un usuario existente.
     */
    public function darDeBajaUsuario(User $usuario): User
    {
        $valoresViejos = $usuario->toArray();

        $usuario->update([
            'estado' => false,
        ]);

        $this->registrarOperacion(
            AccionAuditoria::ELIMINACION,
            $usuario->fresh(),
            $valoresViejos,
            $usuario->fresh()->toArray(),
        );

        return $usuario->fresh();
    }

    /**
     * @param  array<string, mixed>|null  $valoresViejos
     * @param  array<string, mixed>|null  $valoresNuevos
     */
    private function registrarOperacion(
        AccionAuditoria $accion,
        User $auditable,
        ?array $valoresViejos,
        ?array $valoresNuevos,
    ): void {
        $operador = Auth::user();

        if (! $operador instanceof User) {
            return;
        }

        $this->auditoriaService->registrar(
            operador: $operador,
            accion: $accion,
            modulo: 'usuarios',
            auditable: $auditable,
            valoresViejos: $valoresViejos,
            valoresNuevos: $valoresNuevos,
            direccionIp: request()->ip(),
        );
    }
}
