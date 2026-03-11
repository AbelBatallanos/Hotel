<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estados extends Model
{
    use SoftDeletes;
    protected $fillable = ["nombre"];
}
