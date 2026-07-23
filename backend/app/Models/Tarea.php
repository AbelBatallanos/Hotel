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

    public function empleado(){
        return $this->belongsTo(Empleado::class, "id_empleado");
    }
    public function estado(){
        return $this->belongsTo(Estados::class, "id_estado");
    }

    public function scopePendientes($query){
        return $query->where("id_estado", 5);
    }

    public function scopePertenece($query, $idEmpleado){
        return $query->where("id_empleado", $idEmpleado);
    }
}
