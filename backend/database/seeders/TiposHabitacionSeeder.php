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
                'precio_base' => 100.00,
                'amenities' => 'WiFi gratuito, TV por cable, escritorio',
                'tipo_cama' => 'Individual',
                'capacidad' => 1,
            ],
            [
                'nombre' => 'Doble',
                'precio_base' => 180.00,
                'amenities' => 'WiFi gratuito, TV por cable, aire acondicionado',
                'tipo_cama' => 'Dos camas individuales',
                'capacidad' => 2,
            ],
            [
                'nombre' => 'Matrimonial',
                'precio_base' => 250.00,
                'amenities' => 'WiFi gratuito, TV por cable, minibar, aire acondicionado',
                'tipo_cama' => 'Cama Queen',
                'capacidad' => 2,
            ],
            [
                'nombre' => 'Suite Deluxe',
                'precio_base' => 500.00,
                'amenities' => 'WiFi gratuito, TV por cable, jacuzzi, minibar, aire acondicionado, sala de estar',
                'tipo_cama' => 'Cama King',
                'capacidad' => 4,
            ],
        ];

        foreach ($tipos as $tipo) {
            TiposHabitacion::create($tipo);
        }
    }
}
