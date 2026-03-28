<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoritoController extends Controller
{

    public function misFavoritos(Request $request)
    {
        $cliente = $request->user()->cliente()->id;

        $favoritos = Favorito::where("id_user", $cliente)->get();

        return response()->json(["favoritos" => $favoritos]);
    }

    public function store(Request $request)
    {
        $cliente = $request->user()->cliente->id;
        $request->validate([
            "id_habitacion" => "required|exists:habitaciones,id",
        ]);
        try {
            Favorito::create([
                "id_habitacion" => $request->id_habitacion,
                "id_cliente" => $cliente,
            ]);
            return response()->json(["message" => "Favorito Agregado con Exito!..."], 201);
        } catch (\Throwable $th) {
            Log::error("Error al storaFavorito" . $th->getMessage());
            return response()->json(["error" => "fallo el server"], 500);
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
