<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoritoController extends Controller
{

    public function misFavoritos(Request $request)
    {
        $cliente = $request->user()->cliente->id;

        $favoritos = Favorito::obtenerPropiosDisponibles($cliente)->get();

        return response()->json(["favoritos" => $favoritos]);
    }

    public function store(Request $request)
    {
        $cliente = $request->user()->cliente->id;
        $request->validate([
            "id_habitacion" => "required|numeric|exists:habitaciones,id",
        ]);
        
        try {

            $exist = Favorito::existenDatos($request->id_habitacion, $cliente);
            if($exist){
                return response()->json(["error"=> "Ya lo tiene agregado como favorito"], 400);
            }
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

    public function destroy(Request $request,$idFavorito)
    {
        try {
            $favorito = Favorito::pertenece($idFavorito, $request->user()->cliente->id)->firstOrFail();
            
            $favorito->delete();
            return response()->json(["message"=> "favorito eliminado con exitoso"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error"=>"El favorito {$idFavorito} no existe"], 404);
        }catch (\Throwable $th) {
             return response()->json(["error" => $th->getMessage()], 500);
        }

    }
}
