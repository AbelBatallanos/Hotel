<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitaciones extends Model
{
    use SoftDeletes;
    protected $fillable = ["tipo_habitacion_id", "codigo", "estado_id", "capacidad", "imagen", "descripcion"];

    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }
    public function tipohabitacion()
    {
        return $this->belongsTo(TiposHabitacion::class, "tipo_habitacion_id");
    }
}
