<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reparacion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "detalle_averia",
        "fecha_reporte",
        "fecha_resolucion",
        "id_proveedor",
        "id_habitacion",
        "id_empleado",
        "id_estado"
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, "id_proveedor");
    }
    public function habitacion()
    {
        return $this->belongsTo(Habitaciones::class, "id_habitacion");
    }
    public function estado()
    {
        return $this->belongsTo(Estados::class, "id_estado");
    }
}
