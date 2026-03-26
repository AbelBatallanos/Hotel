<?php

namespace Database\Seeders;

use App\Models\Turno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turnos = [
            [
                "descripcion" => "mañana",
                "hora_entrada" => "06:00:00",
                "hora_salida" => "14:00:00",
            ],
            [
                "descripcion" => "tarde",
                "hora_entrada" => "14:00:00",
                "hora_salida" => "22:00:00",
            ],
            [
                "descripcion" => "noche",
                "hora_entrada" => "22:00:00",
                "hora_salida" => "06:00:00",
            ],
        ];

        foreach ($turnos as $turno) {
            Turno::create([
                "descripcion" => $turno["descripcion"],
                "hora_entrada" => $turno["hora_entrada"],
                "hora_salida" =>  $turno["hora_salida"],
            ]);
        }
    }
}
