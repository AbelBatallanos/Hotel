<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string"
        ]);
        try {
            Roles::created([
                "nombre" => $request->nombre,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
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
            if ($rol && $request->has("nombre")) {
                $rol->update(["nombre" => $request->nombre]);
                return;
            }
            Log::info("Rol update correctamente");
            return response()->json(["messageError" => "No se encontro el Rol"]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de update rol inexistente', ['id' => $id]);
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
            Log::info("Rol Eliminado correctamente");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar rol inexistente', ['id' => $id]);
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
