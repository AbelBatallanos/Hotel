<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ["total", "fecha_ini", "fecha_fin", "user_id", "estado_id"];

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
