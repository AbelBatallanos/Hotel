<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $fields = $request->validate([
                "name" => 'required|string',
                "email" => 'required|string|unique:users,email',
                "password" => 'required|string',
                "rol_id" => 'required|exists:roles,id',
            ]);

            $user = User::create([
                "name" => $fields["name"],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'rol_id' => $fields['rol_id']
            ]);

            $token = $user->createToken("hotel_token")->plainTextToken;

            return response()->json(["user" => ["email" => $user->email, "name" => $user->name, "rol" => $user->rol->nombre], "token" => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lanzamos el error de validación para que Laravel envíe el 422 automático
            throw $e;
        } catch (\Exception $e) {
            // Errores graves (base de datos caída, etc)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $fields = $request->validate([
                "email" => 'required|string',
                "password" => 'required|string',
            ]);

            $user = User::where("email", $fields["email"])->first();
            if (!$user || !Hash::check($fields["password"], $user->password)) {
                return response(["messageError" => "Credenciales Incorrectas"], 400);
            }

            $token = $user->createToken("hotel_token")->plainTextToken;

            return response()->json(["user" => ["email" => $user->email, "name" => $user->name, "rol" => $user->rol->nombre], "token" => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lanzamos el error de validación para que Laravel envíe el 422 automático
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error interno del servidor',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Elimina el token actual del usuario autenticado
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                "message" => "Sesión cerrada correctamente"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "No se pudo cerrar sesión",
                "details" => $e->getMessage()
            ], 500);
        }
    }
}
