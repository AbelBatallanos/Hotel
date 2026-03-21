<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Services\UserCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{

    protected $usercreator;

    public function __construct(UserCreatorService $userCreator)
    {
        $this->usercreator = $userCreator;
    }

    public function storeNuevo(Request $request)
    {
        Log::info("Creando Nuevo Empleado en el metodo storeNuevo", ["request" => $request->all()]);

        $request->validate([
            "name" => "required|string",
            "lastname" => "required|string",
            "email" => "required|string",
            "password" => "required|string",
            "rol_id" => "required|exists:roles,id",


            "id_turno" => "required|exists:turnos,id",
            "sueldo" => "required|numeric",
            "historial_notas" => "sometimes|string"
        ]);
        try {
            $this->usercreator->createEmpleado($request->all());
            Log::info("Creacion de nuevo empleado completada");
            return response()->json(["message" => "Se registro nuevo empleado con exito!.."], 201);
        } catch (\Throwable $th) {
            Log::error("Error inesperado en StoreNuevo ", [
                "mensaje" => $th->getMessage(),
                "linea" => $th->getLine(),
                "archivo" => $th->getFile(),
                "codigo" => $th->getCode()
            ]);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "sueldo" => "sometimes|numeric",
            "id_turno" => "sometimes|exists:turnos,id",
            "historial_notas" => "sometimes|string",
        ]);

        try {
            $empleado = Empleado::findOrFail($id);

            if ($request->has("sueldo")) $empleado->sueldo = $request->sueldo;
            if ($request->has("id_turno")) $empleado->id_turno = $request->id_turno;
            if ($request->has("historial_notas")) $empleado->historial_notas = $request->historial_notas;

            $empleado->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }
}
