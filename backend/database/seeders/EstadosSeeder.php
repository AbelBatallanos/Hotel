<?php

namespace Database\Seeders;

use App\Models\Estados;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = ['Disponible', 'Ocupada', 'Mantenimiento', 'Limpieza', 'Pendiente', 'Pagado', 'Cancelado', 'Realizado'];

        foreach ($estados as $estado) {
            Estados::create(['nombre' => $estado]);
        }
    }
}
