<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
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

    public function storePersonal(Request $request)
    {

        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "rol" => "required|exists:roles,id",
        ]);

        User::create([
            "name" => $fields["name"],
            'email' => $fields['email'],
            'password' => Hash::make(12345678),
            'rol_id' => $fields['rol'],
        ]);

        return response()->json([
            "message" => "Personal Registrado con Exito!",
            "estado" => 201
        ], 201);
    }
}
