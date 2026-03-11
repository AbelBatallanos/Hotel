<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TipoHabitacionResource;
use App\Models\TiposHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    public function getAll()
    {
        return TipoHabitacionResource::collection(TiposHabitacion::all());
    }
}
