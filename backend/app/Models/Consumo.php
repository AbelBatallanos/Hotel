<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumo extends Model
{
    use SoftDeletes;


    public function consumible()
    {
        return $this->morphTo();
    }
}
