<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    protected $fillable = [
        "id_user",
        "preferencias",
        "puntos_acumulados",
        "nivel_fidelidad"
    ];


    public function user()
    {
        return $this->belongsTo(User::class, "id_user");
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, "id_cliente");
    }
}
