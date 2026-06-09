<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\MembresiaService;
use Illuminate\Database\Seeder;

class MembresiaSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(MembresiaService::class);

        $membresias = [
            [
                'nombre_plan' => 'Mensual',
                'precio' => 30000.00,
                'duracion_dias' => 30,
            ],
            [
                'nombre_plan' => 'Semanal',
                'precio' => 12000.00,
                'duracion_dias' => 7,
            ],
            [
                'nombre_plan' => 'Diario',
                'precio' => 3000.00,
                'duracion_dias' => 1,
            ],
        ];

        foreach ($membresias as $membresia) {
            $service->crearMembresia($membresia);
        }
    }
}
