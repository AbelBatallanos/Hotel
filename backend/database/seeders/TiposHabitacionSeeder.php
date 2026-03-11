<?php

namespace Database\Seeders;

use App\Models\TiposHabitacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Simple',
                'precio_base' => 100,
            ],
            [
                'nombre' => 'Doble',
                'precio_base' => 180,
            ],
            [
                'nombre' => 'Matrimonial',
                'precio_base' => 250,
            ],
            [
                'nombre' => 'Suite Deluxe',
                'precio_base' => 500,
            ],
        ];

        foreach ($tipos as $tipo) {
            TiposHabitacion::create($tipo);
        }
    }
}
