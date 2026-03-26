<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitaciones extends Model
{
    use SoftDeletes;
    protected $fillable = ["id_tipo_habitacion", "num_habitacion", "id_estado", "imagen", "descripcion"];

    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }
    public function tipohabitacion()
    {
        return $this->belongsTo(TiposHabitacion::class, "id_tipo_habitacion");
    }
}
