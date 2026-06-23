<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Http\Requests\Auth\RegisterPersonalRequest;
use App\Http\Resources\UserResource;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

use function Illuminate\Support\now;

class UserController extends Controller
{
    public function getAllPersonal()
    {
        $personal = User::where("rol_id", 2)->get();

        return response()->json([
            "personal" => UserResource::collection($personal),
            "estado" => 200
        ], 200);
    }

    public function storePersonal(RegisterPersonalRequest $request)
    {

        $fields = $request->validated();

        $user = User::create([
            "name" => $fields["name"],
            "lastname"=> $fields["lastname"],
            'email' => $fields['email'],
            'password' => Hash::make($fields["password"]) ?? Hash::make(12345678),
            "ci"=> $fields["ci"],
            'rol_id' => $fields['rol'],
            "es_empleado"=> 1,
        ]);

        Empleado::create([
            "id_user" => $user->id,
            "id_turno"=> $fields["turno"],
            "fechahora_contratacion"=>  now()->toDateTimeString(),
        ]);
        return response()->json([
            "message" => "Personal Registrado con Exito!",
            "estado" => 201
        ], 201);
    }

    public function getAllUsers()
    {
        return response()->json(["data" => User::all()]);
    }



    public function storeCliente(RegisterAuthRequest $request){
        $fields =$request->validated();
        $fields["rol_id"]= 3;
        $fields["es_cliente"]= true;
        $cliente=User::create($fields);
        Cliente::create([
            "id_user" => $cliente->id
        ]);

        $token = $cliente->createToken("hotel_token")->plainTextToken;
        return response()->json(["user" => ["email" => $cliente->email, "name" => $cliente->name, "rol" => $cliente->rol->nombre], "token" => $token], 201);
    }
}
