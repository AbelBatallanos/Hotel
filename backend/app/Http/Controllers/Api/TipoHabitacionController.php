<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TiposHabitacion\StoreTiposHabitacionRequest;
use App\Http\Resources\TipoHabitacionResource;
use App\Models\TiposHabitacion;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class TipoHabitacionController extends Controller
{
    public function getAll()
    {
        return TipoHabitacionResource::collection(TiposHabitacion::all());
    }

    public function store(StoreTiposHabitacionRequest $request)
    {
        $data = $request->validated();


        try {
            TiposHabitacion::create([
                "tipo_cama" => $data["tipo_cama"],
                "amenities" => $data["amenities"],
                "capacidad" => $data["capacidad"],
                "nombre" => $data["nombre"],
                "precio_base" => $data["precio_base"],
            ]);
            return response()->json(["message" => "Creado con Exito!.."]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "tipo_cama" => "sometimes|string",
            "amenities" => "sometimes|string",
            "capacidad" => "sometimes|numeric",
            "nombre" => "sometimes|string",
            "precio_base" => "sometimes|numeric",

        ]);

        try {
            $tiphab = TiposHabitacion::findOrFail($id);

            if ($request->has("tipo_cama")) $tiphab->tipo_cama = $request->tipo_cama;
            if ($request->has("amenities")) $tiphab->amenities = $request->amenities;
            if ($request->has("capacidad")) $tiphab->capacidad = $request->capacidad;
            if ($request->has("nombre")) $tiphab->nombre = $request->nombre;
            if ($request->has("precio_base")) $tiphab->precio_base = $request->precio_base;

            $tiphab->save();

            return response()->json(["message" => "Actualizado Correctamente"], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $tiphab = TiposHabitacion::findOrFail($id);

            $tiphab->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
