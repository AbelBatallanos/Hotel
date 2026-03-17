<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReservaDetalle;
use Illuminate\Http\Request;

class ReservaDetalleController extends Controller
{
    //

    public function destroy($id)
    {
        try {
            $detalle = ReservaDetalle::findOrFail($id);

            $detalle->habitacion->update(["estado_id" => 1]);
            $detalle->update(["estado_id" => 7]);
            $detalle->delete();

            return response()->json([
                "message" => "Detalle eliminado correctamente",
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
