<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{

    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\TareaFactory> */
    use HasFactory;

    protected $fillable = [
        "descripcion",
        "fecha_creada",
        "fecha_limite",
        "id_empleado",
        "id_estado"
    ];

    protected $casts = [
        'fecha_creada' => 'datetime',
        'fecha_limite' => 'datetime',
    ];
}
