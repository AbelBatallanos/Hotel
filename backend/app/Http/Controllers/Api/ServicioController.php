<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Servicio\StoreServicioRequest;
use App\Models\Servicio;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
    public function index()
    {
        // $servicios = Servicio::with(["departamento"])->paginate(30);
        $servicios = Servicio::get();
        return response()->json(["servicios" => $servicios]);
    }

    public function store(StoreServicioRequest $request)
    {
        Log::info("En el metodo store de servicio", ["request" => $request->all()]);
        $validated = $request->validated();
        try {
            Servicio::create([
                "costo_unit" => $validated["costo_unit"],
                "nombre" => $validated["nombre"],
                "id_departamento" => $validated["id_departamento"],

            ]);
            Log::info("Creado con exito");
            return response()->json(["message" => "Servicio creado con éxito!"], 201);
        } catch (\Throwable $th) {
            Log::error("Error al crear servicio", ["error" => $th->getMessage()]);
            return response()->json(["message" => "Error al crear servicio"], 500);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "costo_unit" => "nullable|numeric|min:0",
            "nombre" => "nullable|string",
            "id_dpto" => "nullable|numeric|exists:departamentos,id",
        ]);
        try {
            $servicio = Servicio::findOrFail($id);

            if ($request->has("costo_unit")) $servicio->costo_unit = $request->costo_unit;
            if ($request->has("nombre")) $servicio->nombre = $request->nombre;
            if ($request->has("id_dpto")) $servicio->id_departamento = $request->id_dpto;
            $servicio->updated_at = now();
            $servicio->save();
            return response()->json(["message" => "Servicio Actualizado"], 200);
        } catch (\Throwable $th) {
            Log::error("Error inesperado al update servicio", ["id" => $id, "message" => $th->getMessage()]);
            return response()->json(["messageError" => "No Existe el Servicio"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();
        } catch (\Throwable $th) {
            Log::error("Error inesperado al update servicio", ["id" => $id, "message" => $th->getMessage()]);
            return response()->json(["messageError" => "No Existe el Servicio"], 404);
        }
    }
}
