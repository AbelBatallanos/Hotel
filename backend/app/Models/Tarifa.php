<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarifa extends Model
{
    use SoftDeletes;
    protected $filltable = ["fecha_ini", "fecha_fin", "id_tipo_habitacion", "precio"];
}
