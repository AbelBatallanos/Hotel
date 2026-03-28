<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ["origen_reserva", "total", "fecha_ini", "fecha_fin", "id_recepcion", "id_cliente", "estado_id"];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "id_cliente");
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, "id_recepcion");
    }
    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }

    public function detalles()
    {
        return $this->hasMany(ReservaDetalle::class, "reserva_id");
    }

    public function consumos()
    {
        return $this->morphMany(Consumo::class, "consumible");
    }
}
