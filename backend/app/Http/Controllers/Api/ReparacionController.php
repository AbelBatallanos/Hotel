<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class ReparacionController extends Controller
{
    public function verTodasReparaciones()
    {
        return;
    }

    public function store(Request $request)
    {
        $request->validate([]);

        try {
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }
}
