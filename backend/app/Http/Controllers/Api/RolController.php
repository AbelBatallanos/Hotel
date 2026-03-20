<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string"
        ]);
        try {
            Roles::created([
                "nombre" => $request->nombre,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "nombre" => "sometimes|string",
        ]);

        try {
            $rol = Roles::findOrfail($id);
            if ($rol && $request->has("nombre")) {
                $rol->update(["nombre" => $request->nombre]);
                return;
            }
            return response()->json(["messageError" => "No se encontro el Rol"]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
