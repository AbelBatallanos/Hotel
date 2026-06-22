<?php

namespace Database\Seeders;

use App\Models\Habitaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $habitaciones=[
            [
                'num_habitacion' => '101',
                'imagen' => 'habitacion101.jpg',
                'id_tipo_habitacion' => 1,
                'id_estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'num_habitacion' => '102',
                'imagen' => 'habitacion102.jpg',
                'id_tipo_habitacion' => 2,
                'id_estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'num_habitacion' => '201',
                'imagen' => 'habitacion201.jpg',
                'id_tipo_habitacion' => 3,
                'id_estado' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'num_habitacion' => '202',
                'imagen' => 'habitacion202.jpg',
                'id_tipo_habitacion' => 4,
                'id_estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Habitaciones::insert($habitaciones);

    }

}