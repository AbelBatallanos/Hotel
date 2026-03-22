<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{

    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            "id_habitacion" => "required|exists:habitaciones,id",
        ]);
        try {
            Favorito::create([
                "id_habitacion" => $request->id_habitacion,
                "id_user" => $user->id,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $favorito = Favorito::findOrFail($id);
            $favorito->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
