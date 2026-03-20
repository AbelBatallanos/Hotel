<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;

    protected $filltable = ["costo_unit", "nombre", "id_departamento"];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, "id_departamento");
    }
}
