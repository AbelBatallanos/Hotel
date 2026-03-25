<?php

namespace App\Services;

use App\Models\Reparacion;
use Illuminate\Support\Facades\DB;

class ReparacionService
{
    public function update(Reparacion $reparacion, array $datarequest, $user)
    {
        DB::transaction(function () use ($reparacion, $datarequest, $user) {
            if ($user->rol_id == 1) { //admin puede asignar empleado o proveedor
                if (isset($datarequest["id_empleado"])) $reparacion->id_empleado = $datarequest["id_empleado"];
                if (isset($datarequest["id_proveedor"])) $reparacion->id_proveedor = $datarequest["id_proveedor"];
            }
            $reparacion->fecha_resolucion = now() - today();
            foreach (['costo_reparacion', 'id_estado'] as $field) {
                if (array_key_exists($field, $datarequest)) {
                    $reparacion->{$field} = $datarequest[$field];
                }
            }
            $reparacion->save();

            if ($reparacion->wasChanged("id_estado") && $reparacion->id_estado == 8 && $reparacion->id_empleado) {
                event(new \App\Events\ReparacionResolved($reparacion, $user));
            }
        });
    }

    public function claim(Reparacion $reparacion, $empleado)
    {
        $update = Reparacion::where("id", $reparacion->id)->whereNull("id_empleado")->update(["id_empleado" => $empleado->id]);

        return $update > 0;
    }
}
