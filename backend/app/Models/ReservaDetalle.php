<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservaDetalle extends Model
{
    use SoftDeletes;

    protected $fillable = ["reserva_id", "habitacion_id", "subtotal", "estado_id"];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, "reserva_id");
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, "habitacion_id");
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }
}
