<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tarea\StoreTareaRequest;
use App\Http\Requests\Tarea\UpdateTareaRequest;
use App\Models\Tarea;
use App\Services\TareaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    protected $tareaService; 

    public function __construct(TareaService $_tareaService )
    {
        $this->tareaService = $_tareaService;
    }
    public function listarTareas()
    {
        try {
            $tareas = Tarea::with(["empleado", "estado"])->pendientes()->get();
            if (!$tareas) return response()->json(["message" => "No Existen Tareas Pendientes Registradas, Cree una nueva Tarea"], 404);
            return response()->json(["tareas" => $tareas], 200);
        } catch (\Throwable $th) {
        }
    }

    public function MisTareas(Request $request)
    {
        $cliente = $request->user()->cliente->id;

        $tareas = Tarea::pertenence($cliente)->pendientes()->get();

        if (!$tareas) return response()->json(["message" => "No Cuentas con Tareas Pendientes"], 404);
        return response()->json(["tarea" => $tareas], 200);
    }


    public function asignarTarea(StoreTareaRequest $request)
    {
        Log::info('Entrando al método asignarTarea', ['request' => $request->all()]);
        $data = $request->validated();

        try {
            $tarea = $this->tareaService->crearTarea($data);
            
            return response()->json(["tarea" => $tarea], 201);
        } catch (\Throwable $th) {
            Log::error('Error al asignar tarea', [
                'mensaje' => $th->getMessage(),
                'linea' => $th->getLine(),
                'archivo' => $th->getFile(),
            ]);
        }
    }

    public function updateTarea($id, UpdateTareaRequest $request)
    {
        Log::info('Entrando al método updateTarea', ['request' => $request->all()]);

        $datos= $request->validated();

        try {
            $tarea = Tarea::findOrFail($id);

            $tarea->update($datos);
            Log::info('Tarea actualizada correctamente', ['id' => $id]);
            return response()->json(["message" => "Tarea Actualizada con Exito!.."], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Intento de actualizar tarea inexistente', ['id' => $id]);
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
            
            $tarea->update(["id_estado"=> 7]);
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
