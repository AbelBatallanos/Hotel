<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    protected $usercreator;

    public function __construct(UserCreatorService $userCreator)
    {
        $this->usercreator = $userCreator;
    }

    public function index()
    {
        return;
    }

    public function storeNuevoCliente(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "lastname" => "required|string",
            "email" => "required|string",
            "password" => "required|string",

            "preferencia" => "required|exists:turnos,id",
        ]);

        try {
            $cliente = $this->usercreator->createCliente($request->all());
            return response()->json(["message" => "Cuenta Creada con Exito", "cliente_data" => $cliente], 201);
        } catch (\Throwable $th) {
            Log::error("Error inesperado en storeCliente", [
                "mensaje" => $th->getMessage(),
                "codigo" => $th->getCode(),
                "linea" => $th->getLine(),
                "file" => $th->getFile(),

            ]);
        }
    }

    public function updateData($id, Request $request)
    {
        return;
    }
}
