<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $request->validate([
            "tipo_cama" => "required|string",
            "amenities" => "required|string",
            "capacidad" => "required|numeric",
            "nombre" => "required|string",
            "precio_base" => "required|numeric",

        ]);

        try {
            TiposHabitacion::create([
                ""
            ]);
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
