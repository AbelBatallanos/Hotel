<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function register(RegisterAuthRequest $request)
    {
        $validated =  $request->validated();
        try {
            
            $user = User::create([
                "name" => $validated["name"],
                "lastname" => $validated["lastname"],
                "ci" => $validated["ci"],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'rol_id' => $validated['rol_id']
            ]);

            $token = $user->createToken("hotel_token")->plainTextToken;

            return response()->json(["user" => ["email" => $user->email, "name" => $user->name, "rol" => $user->rol->nombre], "token" => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lanzamos el error de validación para que Laravel envíe el 422 automático
            return response()->json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            // Errores graves (base de datos caída, etc)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function login(LoginAuthRequest $request)
    {
        try {
            $fields = $request->validated();

            $user = User::where("email", $fields["email"])->first();
            if (!$user || !Hash::check($fields["password"], $user->password)) {
                return response()->json(["error" => "Credenciales Incorrectas"], 400);
            }

            $token = $user->createToken("hotel_token")->plainTextToken;

            return response()->json(["user" => ["email" => $user->email, "name" => $user->name, "rol" => $user->rol->nombre], "token" => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lanzamos el error de validación para que Laravel envíe el 422 automático
            throw $e;
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
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
