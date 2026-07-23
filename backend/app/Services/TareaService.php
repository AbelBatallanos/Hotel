<?php
namespace App\Services;

use App\Models\Tarea;
use Illuminate\Support\Facades\Log;

class TareaService{

    public function crearTarea(array $datos){

        $tarea = Tarea::create([

            "descripcion" => $datos["descripcion"],
            "fecha_creada" => now(),
            "fecha_limite" => $datos["fecha_limite"],
            "id_empleado" => $datos["id_empleado"],
            "cargo"=> $datos["cargo"],
            "id_estado" => 5,
        ]);
        Log::info('Tarea creada correctamente', ['tarea' => $tarea]);
        return $tarea;
    }

}



?>