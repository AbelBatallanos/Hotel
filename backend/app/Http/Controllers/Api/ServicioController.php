<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with(["departamento"])->pagination();

        return response()->json(["servicios" => $servicios]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "costo_unit" => "required|numeric|min:0",
            "nombre" => "required|string",
            "id_dpto" => "required|numeric|exists:departamento,id",
        ]);

        Servicio::create([
            "costo_unit" => $request->costo_unit,
            "nombre" => $request->nombre,
            "id_departamento" => $request->id_dpto,

        ]);
        return response()->json(["message" => "Servicio Creado Con exito!.."]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "costo_unit" => "sometimes|numeric|min:0",
            "nombre" => "sometimes|string",
            "id_dpto" => "sometimes|numeric|exists:departamento,id",
        ]);
        try {
            $servicio = Servicio::findOrFail($id);

            if ($request->has("costo_unit")) $servicio->costo_unit = $request->costo_unit;
            if ($request->has("nombre")) $servicio->nombre = $request->nombre;
            if ($request->has("id_dpto")) $servicio->id_dpto = $request->id_dpto;

            $servicio->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }

    public function destroy($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }
}
