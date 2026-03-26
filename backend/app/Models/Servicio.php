<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    protected $table = "servicios";
    protected $fillable = ["costo_unit", "nombre", "id_departamento"];

    protected $casts = [
        "costo_unit" => "decimal:2",
        "nombre" => "string",
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, "id_departamento");
    }
}
