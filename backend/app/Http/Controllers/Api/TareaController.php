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

            return response()->json([]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    public function asignarTarea(Request $request)
    {
        Log::info('Entrando al método asignarTarea', ['request' => $request->all()]);
        $request->validate([
            "descripcion" => "required|string",
            "fecha_limite" => "required",
            "id_empleado" => "required|exists:empleado,id",
            "id_estado" => "required|exists:estado,id",
        ]);

        try {
            Tarea::create([
                "descripcion" => $request->descripcion,
                "fecha_limite" => $request->fecha_limite,
                "id_empleado" => $request->empleado,
                "id_estado" => $request->estado,
            ]);
            Log::info('Tarea creada correctamente', ['empleado' => $request->empleado]);
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

            $tarea->delete();
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
