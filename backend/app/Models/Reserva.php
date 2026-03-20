<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ["origen_reserva", "codigo_promocion", "descuento_monto", "total", "fecha_ini", "fecha_fin", "id_recepcion", "id_cliente", "estado_id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }

    public function detalles()
    {
        return $this->hasMany(ReservaDetalle::class, "reserva_id");
    }
}
