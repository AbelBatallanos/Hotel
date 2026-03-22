<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorito extends Model
{
    use SoftDeletes;


    protected $fillable = ["id_user", "id_habitacion"];

    public function user()
    {
        return $this->belongsTo(User::class, "id_user");
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, "id_habitacion");
    }
}
