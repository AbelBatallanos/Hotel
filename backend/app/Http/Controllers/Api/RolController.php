<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{

    public function index()
    {

        $roles = Roles::get();
        return response()->json(["roles" => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string|unique:roles,nombre"
        ]);
        try {
            Roles::create([
                "nombre" => $request->nombre,
            ]);
            return response()->json(["message" => "Se Registro con Exito!...."]);
        } catch (\Throwable $th) {
            Log::error("Error store Role" . $th->getMessage());
            return response()->json("error", 500);
        }
        return;
    }

    public function update($id, Request $request)
    {
        Log::info("En Rol usando el metodo update", ["id" => $id]);
        $request->validate([
            "nombre" => "sometimes|string",
        ]);

        try {
            $rol = Roles::findOrfail($id);
            $rol->update(["nombre" => $request->nombre]);
            Log::info("Rol update correctamente");
            return response()->json(["message" => "Rol Actualizado Correctamente!..."]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de update rol inexistente', ['id' => $id]);
            return response()->json(["messageError" => "No se encontro el Rol"]);
        } catch (\Throwable $th) {
            Log::error("Error en update rol", [
                "mensaje" => $th->getMessage(),
                "file" => $th->getFile(),
                "Codigo" => $th->getCode(),
                "linea" => $th->getLine
            ]);
        }
    }

    public function destroy($id)
    {
        Log::info("En Rol usando el metodo Destroy", ["id" => $id]);
        try {
            $rol = Roles::findOrFail($id);
            $rol->delete();
            return response()->json(["message" => "Rol Eliminado Correctamente!..."]);
            Log::info("Rol Eliminado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar rol inexistente', ['id' => $id]);
            return response()->json(["messageError" => "No se encontro el Rol"]);
        } catch (\Throwable $th) {
            Log::error("Error en eliminar rol", [
                "mensaje" => $th->getMessage(),
                "file" => $th->getFile(),
                "Codigo" => $th->getCode(),
                "linea" => $th->getLine
            ]);
        }
    }
}
