<?php
namespace App\Services;

use App\Models\Habitaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class HabitacionService {

    public function crearHabitacion(array $datos ,$imagen=null) {

        DB::transaction(function () use($datos, $imagen)  {
            
            if($imagen){
                $path = $imagen->store('habitaciones', 'public');
                $datos["imagen"] = "/storage/" . $path;
            }
    
            $datos["id_estado"]=1;
            return Habitaciones::create($datos);
        });
    }

    public function updateHabitacion(Habitaciones $habitacion, array $datos, $imagen=null){

        if($imagen){

            if($habitacion->imagen){
                $anteriorRuta = str_replace('/storage/', '', $habitacion->imagen);
                Storage::disk('public')->delete($anteriorRuta);
            }
            $path = $imagen->store('habitaciones', 'public');
            $datos["imagen"]= '/storage/' . $path;;
        }
        $habitacion->update($datos);
        return $habitacion;
    }


}






?>