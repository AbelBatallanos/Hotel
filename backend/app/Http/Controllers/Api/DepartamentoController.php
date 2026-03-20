<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Support\Facades\Log;

class DepartamentoController extends Controller
{
    public function index()
    {
        $dptos = Departamento::all();

        return response()->json(["departamentos" => $dptos], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|max:50|unique:departamento,nombre"
        ]);

        Departamento::created([
            "nombre" => $request->nombre,
        ]);

        return response()->json(["message" => "Se registro con exito!"], 201);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "nombre" => "sometimes|string|min:2"
        ]);
        try {
            if ($request->has("nombre")) {
                $dpto = Departamento::findOrFail($id);
                $dpto->nombre = $request->nombre;
                return response()->json(["message" => "Se actualizo los datos con Exito!"]);
            }
        } catch (\Throwable $th) {
            Log::error("Erro inesperado al update dpto", ["id" => $id]);
        }
    }
    public function destroy($id)
    {
        Log::info("Entrando al metodo destroy dpto", ["id" => $id]);
        try {
            $dpto = Departamento::findOrFail($id);
            $dpto->delete();
            Log::info("dpto eliminada correctamente", ["id" => $id]);
            return response()->json(["message" => "Se elimino con Exito!"], 204);
        } catch (\Throwable $th) {
            Log::error("Error inisperado al eliminar dpto", [
                "mensaje" => $th->getMessage(),
                "linea" => $th->getLine(),
                "archivo" => $th->getFile(),
            ]);
        }
    }
}
