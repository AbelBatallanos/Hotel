<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TiposHabitacion\StoreTiposHabitacionRequest;
use App\Http\Requests\TiposHabitacion\UpdateTipoHabitacionRequest;
use App\Http\Resources\TipoHabitacionResource;
use App\Models\TiposHabitacion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function update($id, UpdateTipoHabitacionRequest $request)
    {
        $data = $request->validated();
        try {
            $tiphab = TiposHabitacion::findOrFail($id);
            $data = array_filter($data, fn($v) => !is_null($v) && $v !== '');

            $tiphab->update($data);

            return response()->json(["message" => "Actualizado Correctamente"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No existe ese registro'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tiphab = TiposHabitacion::findOrFail($id);

            $tiphab->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No existe ese registro'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno'], 500);
        }
    }
}
