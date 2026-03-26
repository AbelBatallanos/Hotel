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
            "nombre" => "required|max:50|unique:departamentos,nombre"
        ]);

        Departamento::create([
            "nombre" => $request->nombre,
        ]);

        return response()->json(["message" => "Se registro con exito!"], 201);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "nombre" => "sometimes|string|unique:departamentos,nombre|min:2"
        ]);
        try {
            $dpto = Departamento::findOrFail($id);
            if ($request->has("nombre")) {
                $dpto->nombre = $request->nombre;
                $dpto->save();
                return response()->json(["message" => "Se actualizo los datos con Exito!"]);
            }
        } catch (\Throwable $th) {
            Log::error("Erro inesperado al update dpto", ["id" => $id, "message" => $th->getMessage()]);
            return response()->json(["messageError" => "No Existe el Departamento"], 404);
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

            return response()->json(["messageError" => "No Existe el Departamento"], 404);
        }
    }
}
