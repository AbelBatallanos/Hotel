<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public function listarTareas()
    {
        try {
            $tareas = Tarea::with(["empleado", "estado"])->where("id_estado", 5)->get();
            if (!$tareas) return response()->json(["message" => "No Existen Tareas Pendientes Registradas, Cree una nueva Tarea"], 404);
            return response()->json(["tareas" => $tareas], 200);
        } catch (\Throwable $th) {
        }
    }

    public function MisTareas(Request $request)
    {
        $user = $request->user();

        $tareas = Tarea::where("id_empleado", $user->id)->where("id_estado", 5)->get();

        if (!$tareas) return response()->json(["message" => "No Cuentas con Tareas Pendientes"], 404);
        return response()->json(["tarea" => $tareas], 200);
    }


    public function asignarTarea(Request $request)
    {
        Log::info('Entrando al método asignarTarea', ['request' => $request->all()]);
        $request->validate([
            "descripcion" => "required|string",
            "fecha_limite" => "required",
            "id_empleado" => "required|exists:empleado,id",

        ]);

        try {
            $tarea = Tarea::create([
                "descripcion" => $request->descripcion,
                "fecha_limite" => $request->fecha_limite,
                "id_empleado" => $request->empleado,
                "id_estado" => 5,
            ]);
            Log::info('Tarea creada correctamente', ['tarea' => $tarea]);
            return response()->json(["tarea" => $tarea], 201);
        } catch (\Throwable $th) {
            Log::error('Error al asignar tarea', [
                'mensaje' => $th->getMessage(),
                'linea' => $th->getLine(),
                'archivo' => $th->getFile(),
            ]);
        }
    }

    public function updateTarea($id, Request $request)
    {
        Log::info('Entrando al método updateTarea', ['request' => $request->all()]);

        $request->validate([
            "descripcion" => "sometimes|string",
            "fecha_limite" => "sometimes",
            "empleado" => "sometimes|exists:empleado,id",
            "estado" => "sometimes|exists:estado,id",
        ]);

        try {
            $tarea = Tarea::findOrFail($id);

            if ($request->has("descripcion")) $tarea->descripcion = $request->descripcion;
            if ($request->has("fecha_limite")) $tarea->fecha_limite = $request->fecha_limite;
            if ($request->has("empleado")) $tarea->id_empleado = $request->empleado;
            if ($request->has("estado")) $tarea->id_estado = $request->estado;


            $tarea->save();
            Log::info('Tarea actualizada correctamente', ['id' => $id]);
            return response()->json(["message" => "Tarea Actualizada con Exito!.."], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar tarea inexistente', ['id' => $id]);
        } catch (\Throwable $th) {
            Log::error('Error al actualizar datos de tarea', [
                'mensaje' => $th->getMessage(),
                'linea' => $th->getLine(),
                'archivo' => $th->getFile(),
            ]);
        }
    }

    public function deleteTarea($id)
    {
        Log::info('Entrando al método deleteTarea', ['id' => $id]);
        try {
            $tarea = Tarea::findOrFail($id);
            $tarea->id_estado = 7;
            $tarea->updated_at = now();
            $tarea->save();
            $tarea->delete();
            Log::info('Tarea eliminada correctamente', ['id' => $id]);
            return response()->json(["message" => "Tarea Eliminada con Exito!.."], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de eliminar tarea inexistente', ['id' => $id]);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar tarea', [
                'mensaje' => $th->getMessage(),
                'linea' => $th->getLine(),
                'archivo' => $th->getFile(),
            ]);
        }
    }
}
