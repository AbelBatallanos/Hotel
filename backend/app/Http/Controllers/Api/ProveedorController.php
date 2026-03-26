<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        $provs = Proveedor::all();

        return response()->json(["proveedores" => $provs], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "especialidad" => "required|string",
            "telefono" => "required|integer",
        ]);
        try {
            Proveedor::created([
                "nombre" => $request->nombre,
                "apellidos" => $request->apellidos,
                "especialidad" => $request->especialidad,
                "telefono" => $request->telefono,
            ]);

            return response()->json(["message" => "Proveedor Creado con Exito"], 201);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "nombre" => "sometimes|string",
            "apellidos" => "sometimes|string",
            "especialidad" => "sometimes|string",
            "telefono" => "sometimes|integer",
        ]);

        try {
            $proveedor = Proveedor::findOrFail($id);

            if ($request->nombre) $proveedor->nombre = $request->nombre;
            if ($request->apellidos) $proveedor->apellidos = $request->apellidos;
            if ($request->especialidad) $proveedor->especialidad = $request->especialidad;
            if ($request->telefono) $proveedor->telefono = $request->telefono;
            $proveedor->saved();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function destroy($id)
    {
        try {
            $prov = Proveedor::findOrFail($id);

            $prov->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
