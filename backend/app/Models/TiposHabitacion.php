<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposHabitacion extends Model
{
    use SoftDeletes;
    protected $table = 'tipos_habitacion';
    protected $fillable = ["nombre", "precio_base"];


    public function habitaciones()
    {
        return $this->hasMany(Habitaciones::class, "estado_id");
    }
}
