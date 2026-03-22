<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCreatorService
{

    public function createEmpleado(array $data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'ci' => $data['ci'] ?? "564312456",
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? '12345678'),
                'rol_id' => $data['rol_id'],
                "es_empleado" => true,
            ]);

            $empleado = Empleado::create([
                'fecha_contratacion' => now(),
                'sueldo' => $data['sueldo'],
                'id_user' => $user->id,
                'id_turno' => $data['id_turno'],
                'historial_notas' => $data['historial_notas'] ?? '',
            ]);
            return $empleado;
        });
    }

    public function createCliente(array $data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'ci' => $data['ci'] ?? "564312456",
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? '12345678'),
                'rol_id' => $data['rol_id'],
                "es_cliente" => true,
            ]);

            $cliente = Cliente::create([
                "preferencia" => $data["preferencia"],
                "puntos_acumulados" => $data["puntos_acumulados"],
                "nivel_fidelidad" => $data["nivel_fidelidad"],
                "id_user" => $user->id,

            ]);
            return $cliente;
        });
    }
}
