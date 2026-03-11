<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estados;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function getAllEstados()
    {
        $estados = Estados::all();
        return response()->json($estados, 200);
    }
}
