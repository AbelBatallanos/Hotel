<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory, SoftDeletes;


    protected $fillable = [
        "id_user",
        "fecha_contratacion",
        "sueldo",
        "historial_notas",
        "id_turno"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "id_user");
    }
}
