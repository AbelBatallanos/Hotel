<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorito extends Model
{
    use SoftDeletes;


    protected $fillable = ["id_cliente", "id_habitacion"];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "id_cliente");
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, "id_habitacion");
    }
}
