<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dptos = [
            ['nombre' => 'Housekeeping'],
            ['nombre' => 'Mantenimiento'],
            ['nombre' => 'Restaurante'],
            ['nombre' => 'Bar'],
            ['nombre' => 'Spa'],
            ['nombre' => 'Seguridad'],
            ['nombre' => 'Administración'],
            ['nombre' => 'Eventos'],
        ];

        foreach ($dptos as $dpt) {
            Departamento::create($dpt);
        }
    }
}
