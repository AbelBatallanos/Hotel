<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarifa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TarifaController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::get();
        return response()->json(["tarifas" => $tarifas]);
    }


    public function storeNuevaTarifa(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'tipo_habitacion' => 'required|exists:tipos_habitacion,id',
            'precio' => 'required|numeric|min:0',
        ]);

        //evitar solapamientos activos
        $validador->after(function ($validator) use ($request) {
            $inicio = Carbon::parse($request->fecha_ini);
            $fin = Carbon::parse($request->fecha_fin);
            $tipoHab = $request->tipo_habitacion;

            $existe = Tarifa::where("id_tipo_habitacion", $tipoHab)
                ->where("activo", true)
                ->where(function ($q) use ($inicio, $fin) {
                    $q->whereBetween("fecha_ini", [$inicio, $fin])
                        ->orWhereBetween("fecha_fin", [$inicio, $fin])
                        ->orWhere(function ($q2) use ($inicio, $fin) {
                            $q2->where("fecha_ini", "<=", $inicio)
                                ->where("fecha_fin", ">=", $fin);
                        });
                })->exists();

            if ($existe) {
                $validator->errors()->add('fecha', 'Ya existe una tarifa activa que se solapa en ese rango para ese tipo de habitación.');
            }
        });

        try {
            Tarifa::create([
                "fecha_ini" => $request->fecha_ini,
                "fecha_fin" => $request->fecha_fin,
                "id_tipo_habitacion" => $request->tipo_habitacion,
                "precio" => $request->precio,
            ]);
            return response()->json(["messasge" => "Tarifa Creada con exito!..."], 201);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "fecha_ini" => "sometimes|date",
            "fecha_fin" => "sometimes|date|after_or_equal:fecha_ini",
            "id_tipo_habitacion" => "sometimes|exists:tipos_habitacion,id",
            "precio" => "sometimes|numeric|min:0",
            "activo" => "sometimes|boolean",
        ]);

        $tarifa = Tarifa::findOrFail($id);

        $inicio = $request->has("fecha_ini") ? Carbon::parse($request->fecha_ini) : $tarifa->fecha_ini;
        $fin = $request->has("fecha_fin") ? Carbon::parse($request->fecha_fin) : $tarifa->fecha_fin;
        $tipoHab = $request->has("id_tipo_habitacion") ? $request->id_tipo_habitacion : $tarifa->id_tipo_habitacion;

        $existe = Tarifa::where("id_tipo_habitacion", $tipoHab)
            ->where("activo", true)
            ->where("id", "!=", $tarifa->id)
            ->where(function ($q) use ($inicio, $fin) {
                $q->whereBetween("fecha_ini", [$inicio, $fin])
                    ->orWhereBetween("fecha_fin", [$inicio, $fin])
                    ->orWhere(function ($q2) use ($inicio, $fin) {
                        $q2->where("fecha_ini", "<=", $inicio)
                            ->where("fecha_fin", ">=", $fin);
                    });
            })->exists();
        if ($existe) {
            return response()->json(['error' => 'Existe otra tarifa activa que se solapa en ese rango.'], 422);
        }
        try {
            if ($request->has("fecha_ini")) $tarifa->fecha_ini = $request->fecha_ini;
            if ($request->has("fecha_fin")) $tarifa->fecha_fin = $request->fecha_fin;
            if ($request->has("id_tipo_habitacion")) $tarifa->id_tipo_habitacion = $request->id_tipo_habitacion;
            if ($request->has("precio")) $tarifa->precio = $request->precio;
            if ($request->has("activo")) $tarifa->activo = $request->activo;

            $tarifa->save();
        } catch (\Throwable $th) {
            Log::error('Error actualizando tarifa: ' . $th->getMessage());
            return response()->json(['error' => 'Error interno al actualizar tarifa'], 500);
        }
    }
}
