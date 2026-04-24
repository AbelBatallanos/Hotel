<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reserva\ReservaStoreRequest;
use App\Http\Requests\Reserva\ReservaUpdateRequest;
use App\Http\Resources\ReservaGeneralResource;
use App\Http\Resources\ReservaOcupadosResource;
use App\Http\Resources\ReservaPendientesResource;
use App\Http\Resources\ReservaResource;
use App\Models\Habitaciones;
use App\Models\Reserva;
use App\Models\ReservaDetalle;
use App\Services\ReservaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use function Symfony\Component\Clock\now;

class ReservaController extends Controller
{

    public function getMisReservaciones(Request $request)
    {
        try {
            $userid = $request->user()->cliente->id;
            $misreservas = Reserva::where("id_cliente", $userid)
                ->with(["detalles.habitacion.tipohabitacion"])
                ->get();

            if (!$misreservas->count()) return response()->json(["p" => "esta vacio"]);

            return response()->json(["reservas" => ReservaResource::collection($misreservas)]);
        } catch (\Throwable $th) {
            Log::error("Error en getMisReservas" . $th->getMessage());
            return response()->json("Error en el servidor", 500);
        }
    }


    public function geAllReservaciones() //recepcion
    {
        // $reservaciones_disponibles = Reserva::where("estado_id", 1)->get();
        $reservaciones_pendientes = Reserva::where("estado_id", 5)->with(["cliente", "empleado", "detalles.habitacion.tipohabitacion", "detalles.estado"])->get();
        $reservaciones_ocupados = Reserva::where("estado_id", 2)->with(["user.cliente", "user.empleado", "detalles.habitacion.tipohabitacion", "detalles.estado"])->get();
        return response()->json([
            "Pendientes" => ReservaPendientesResource::collection($reservaciones_pendientes),
            "Ocupados" => ReservaOcupadosResource::collection($reservaciones_ocupados),
        ], 200);
    }


    public function storeReservacion(ReservaStoreRequest $request, ReservaService $reservaservice)
    {
        Log::info('Datos recibidos en storeReservacion:', $request->all());
        $data = $request->validated();
        try {
            $reservaservice->procesarReserva($data, $request->user());
            return response()->json(["message" => "Reservación Registrada Exisotamente"], 201);
        } catch (ValidationException $ve) {
            Log::warning('Validación reserva', ['errors' => $ve->errors()]);
            return response()->json(['error' => 'Datos inválidos', 'details' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al procesar la reserva', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al procesar la reserva', 'details' => $e->getMessage()], 500);
        }
    }

    public function showReservaDetalles(Reserva $reserva)
    {
        $reserva->load(["detalles" => function ($query) {
            $query->where("estado_id", 5);
        }]);

        return response()->json([
            "reserva" => new ReservaGeneralResource($reserva),
        ], 200);
    }

    public function updateReservacionById(ReservaUpdateRequest $request, Reserva $reserva)
    {
        $data = $request->validated();
        try {
            DB::transaction(function () use ($data, $reserva) {
                if (!empty($data['habitaciones'])) {
                    $antiguasIds = $reserva->detalles->pluck('habitacion_id')->unique()->values();
                    Habitaciones::whereIn("id", $antiguasIds)->update(['id_estado' => 1]);

                    $reserva->detalles()->where("estado_id", 5)->update([
                        'estado_id' => 7,
                        'updated_at' => now()
                    ]);
                    $reserva->detalles()->delete();

                    $nuevoTotal = 0;
                    $habitIds = collect($data["habitaciones"])->pluck("id");
                    $habitaciones = Habitaciones::whereIn('id', $habitIds)->get();
                    //Creamdo nuevoas detalles
                    foreach ($habitaciones as $hb) {
                        $descuento = optional($hb->tipohabitacion)->montoDescuento($data["fecha_ini"]) ?? 0;
                        $subtotal = max(0, $hb->tipohabitacion->precio_base - $descuento);
                        $nuevoTotal += $subtotal;

                        $reserva->detalles()->create(
                            [
                                'habitacion_id' => $hb->id,
                                'subtotal' => $subtotal,
                                "estado_id" => 5,
                                "created_at" => now(),
                                "updated_at" => now()
                            ]
                        );
                        $hb->update(["id_estado" => 2]);
                    }

                    $reserva->total = $nuevoTotal;
                }
            });

            //guardamos los nuevos datos de reserva
            $reserva->update(["fecha_ini" => $data["fecha_ini"], "fecha_fin" => $data["fecha_fin"], "updated_at" => today()->format("Y-m-d H:i:s")]);

            return response()->json(['message' => 'Datos actualizados con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Reserva $reserva)
    {
        try {
            return DB::transaction(function () use ($reserva) {

                // 1. Liberar las habitaciones asociadas a esta reserva
                $habitacionesIds = $reserva->detalles->pluck('habitacion_id');
                $detallesIds = $reserva->detalles->pluck('id')->toArray();
                Habitaciones::whereIn('id', $habitacionesIds)->update(['id_estado' => 1]); // Disponible
                ReservaDetalle::whereIn("id", $detallesIds)->update(["estado_id" => 7, 'updated_at' => now()]); //cancelado
                $reserva->detalles()->delete();
                $reserva->delete();

                return response()->json(['message' => 'Reserva cancelada y habitaciones liberadas']);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
