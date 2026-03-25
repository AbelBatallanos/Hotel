<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reparacion\StoreReparacionRequest;
use App\Http\Requests\Reparacion\UpdateReparacionRequest;
use App\Models\Reparacion;
use App\Models\Reserva;
use App\Models\Roles;
use App\Services\ReparacionService;
use Illuminate\Support\Facades\DB;

class ReparacionController extends Controller
{
    public function verReparaciones(Request $request)
    {
        $rolId = $request->user()->rol_id;
        $query = Reparacion::query();

        if ($rolId == 5) {
            $query->where("id_estado", 5);
        } elseif ($rolId == 1) {
            $query->get();
        };

        return $query->wtih(["habitacion", "estado"])->paginate(30);
    }

    public function store(StoreReparacionRequest $request)
    {
        $data = $request->validated();
        try {
            return DB::transaction(function () use ($data) {
                Reparacion::create([
                    "detalle_averia" => $data["detalle_averia"],
                    "id_habitacion" => $data["id_habitacion"],
                    "id_estado" => $data["id_estado"],
                    "fecha_reporte" => now()->today(),
                ]);

                return response()->json(["message" => "Reparacion Creada con Exito"], 201);
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
        return;
    }

    public function TerminarReparacion($id, UpdateReparacionRequest $request, ReparacionService $service)
    {
        $user = $request->user();

        try {
            $reparacion = Reparacion::findOrFail($id);
            $service->update($reparacion, $request->validated(), $user);
            return response()->json(['success' => true, 'reparacion' => $reparacion->fresh()]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function reclamarReparacion($id, Request $request, ReparacionService $service)
    {
        $empleado = $request->user()->empleado();
        try {
            $reparacion = Reparacion::findOrFail($id);
            if (!$service->claim($reparacion, $empleado)) {
                return response()->json(['error' => 'Ya reclamada'], 409);
            };

            return response()->json(['success' => true, "message" => "Reparacion Reclamada Con Exito!...."]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
