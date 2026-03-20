<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReservaDetalle;

class ReservaDetalleController extends Controller
{
    public function destroy($id)
    {
        try {
            $detalle = ReservaDetalle::findOrFail($id);
            $detalle->update(["estado_id", 7]);
            $detalle->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }

    // public function 
}
