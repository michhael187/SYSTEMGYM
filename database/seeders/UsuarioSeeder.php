<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Services\UsuarioService;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(UsuarioService::class);

        $service->crearAdministradorInicial([
            'dni' => 30000001,
            'nombre' => 'Santiago',
            'apellido' => 'Paredes',
            'email' => 'admin@systemgym.test',
            'password' => 'Admin1234!',
        ]);

        $usuarios = [
            [
                'rol' => RolUsuario::GERENTE->value,
                'dni' => 30000002,
                'nombre' => 'Valeria',
                'apellido' => 'Luna',
                'email' => 'valeria.luna@systemgym.test',
                'password' => 'SystemGym1234!',
                'estado' => true,
            ],
            [
                'rol' => RolUsuario::GERENTE->value,
                'dni' => 30000003,
                'nombre' => 'Matias',
                'apellido' => 'Torres',
                'email' => 'matias.torres@systemgym.test',
                'password' => 'SystemGym1234!',
                'estado' => true,
            ],
            [
                'rol' => RolUsuario::GERENTE->value,
                'dni' => 30000004,
                'nombre' => 'Camila',
                'apellido' => 'Rojas',
                'email' => 'camila.rojas@systemgym.test',
                'password' => 'SystemGym1234!',
                'estado' => true,
            ],
            [
                'rol' => RolUsuario::ENCARGADO->value,
                'dni' => 30000005,
                'nombre' => 'Bruno',
                'apellido' => 'Silva',
                'email' => 'bruno.silva@systemgym.test',
                'password' => 'SystemGym1234!',
                'estado' => true,
            ],
            [
                'rol' => RolUsuario::ENCARGADO->value,
                'dni' => 30000006,
                'nombre' => 'Nadia',
                'apellido' => 'Herrera',
                'email' => 'nadia.herrera@systemgym.test',
                'password' => 'SystemGym1234!',
                'estado' => true,
            ],
        ];

        foreach ($usuarios as $usuario) {
            $service->crearUsuario($usuario);
        }
    }
}
