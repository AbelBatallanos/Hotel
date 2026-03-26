<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                "name" => "abel",
                "lastname" => "bc",
                "email" => "ab@gmail.com",
                "ci" => "5533329",
                "password" => "12345678",
                "es_admin" => true,
                "rol_id" => 1
            ],
            [
                "name" => "daniela",
                "lastname" => "rojas gomez",
                "email" => "dani@gmail.com",
                "ci" => "98234123",
                "password" => "12345678",
                "es_empleado" => true,
                "rol_id" => 2,

                "fechahora_contratacion" => now(),
                "sueldo" => 3500.00,
                "id_turno" => 1,

            ],
            [
                "name" => "lucia",
                "lastname" => "vaca mendoza",
                "email" => "lu@gmail.com",
                "ci" => "4445212",
                "password" => "12345678",
                "rol_id" => 3,
                "es_cliente" => true,
                "preferencias" => json_encode(["wifi", "desayuno"]),
                "puntos_acumulados" => 100,
                "nivel_fidelidad" => "Plata",
            ],
        ];

        foreach ($usuarios as $user) {

            $userdb =  User::create([
                "name" => $user["name"],
                "lastname" => $user["lastname"],
                "email" => $user["email"],
                "ci" => $user["ci"],
                "password" => Hash::make($user["password"]), // importante encriptar
                "rol_id" => $user["rol_id"],
                "es_admin" => $user["rol_id"] === 1,
                "es_empleado" => $user["rol_id"] === 2,
                "es_cliente" => $user["rol_id"] === 3,
            ]);

            if ($user["rol_id"] === 2) {
                Empleado::create([
                    "id_user" => $userdb->id,
                    "fechahora_contratacion" => $user["fechahora_contratacion"],
                    "sueldo" => $user["sueldo"],
                    "id_turno" => $user["id_turno"],
                ]);
            }
            if ($user["rol_id"] === 3) {
                Cliente::create([
                    "id_user" => $userdb->id,
                    "preferencias" => $user["preferencias"] ?? null,
                    "puntos_acumulados" => $user["puntos_acumulados"] ?? 0,
                    "nivel_fidelidad" => $user["nivel_fidelidad"] ?? null,
                ]);
            }
        }
    }
}
