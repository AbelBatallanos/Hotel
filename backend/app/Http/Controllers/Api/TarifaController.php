<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarifa;

class TarifaController extends Controller
{
    public function storeNuevaTarifa(Request $request)
    {
        $request->validate([
            "fecha_ini" => "required|date",
            "fecha_fin" => "required|date",
            "tipo_habitacion" => "required|exists:tipo_habitacion,id",
            "precio" => "required|numeric",
        ]);

        try {
            Tarifa::create([
                "fecha_ini" => $request->fecha_ini,
                "fecha_fin" => $request->fecha_fin,
                "id_tipo_habitacion" => $request->tipo_habitacion,
                "precio" => $request->precio,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }

    public function update($id, Request $request){
        
    }
}
