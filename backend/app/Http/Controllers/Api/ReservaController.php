<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservaGeneralResource;
use App\Http\Resources\ReservaOcupadosResource;
use App\Http\Resources\ReservaPendientesResource;
use App\Http\Resources\ReservaResource;
use App\Models\Habitaciones;
use App\Models\Reserva;
use App\Models\ReservaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\Clock\now;

class ReservaController extends Controller
{
    public function getMisReservaciones(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $misreservas = Reserva::where("user_id", $userid)
                ->with(["detalles.habitacion.tipohabitacion"])
                ->get();

            if (!$misreservas->count()) return response()->json(["p" => "esta vacio"]);

            return response()->json(["reservas" => ReservaResource::collection($misreservas)]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        // return response()->json(["user" => $request->user()]);
    }

    public function geAllReservaciones()
    {
        // $reservaciones_disponibles = Reserva::where("estado_id", 1)->get();
        $reservaciones_pendientes = Reserva::where("estado_id", 5)->with(["user"])->get();
        $reservaciones_ocupados = Reserva::where("estado_id", 2)->with(["user", "detalles.habitacion.tipohabitacion", "detalles.estado"])->get();
        return response()->json([
            "Pendientes" => ReservaPendientesResource::collection($reservaciones_pendientes),
            "Ocupados" => ReservaOcupadosResource::collection($reservaciones_ocupados),
        ], 200);
    }


    public function storeReservacion(Request $request)
    {
        Log::info('Datos recibidos en storeReservacion:', $request->all());
        $fields = $request->validate([
            "fecha_ini" => "sometimes|date",
            "fecha_fin" => "sometimes|date",
            "habitaciones" => "required|array|min:1",
            "habitaciones.*.id" => "exists:habitaciones,id"
        ]);
        try {
            $habitacionesIds = collect($fields["habitaciones"])->pluck("id");
            $hab_ocupados = Habitaciones::whereIn("id", $habitacionesIds)->where("estado_id", 2)->get(["id", "codigo"]);

            if ($hab_ocupados->count()) {
                return response()->json([
                    "error" => true,
                    "messageError" => "Algunas habitaciones ya están ocupadas",
                    "ocupadas" => $hab_ocupados,
                    "estado" => 409,
                ], 409);
            }

            //DB::transaction: Si algo falla (ej. se va la luz o un ID está mal), la base de datos no guarda nada a medias.
            return DB::transaction(function () use ($request, $fields) {
                $ids = collect($request->habitaciones)->pluck("id");
                $user = $request->user();
                $total = 0;
                $habitacionesDB = Habitaciones::whereIn("id", $ids)->get();
                $reserva = Reserva::create([
                    "fecha_ini" => $request->fecha_ini ?? today()->format('Y-m-d'),
                    "fecha_fin" =>  $request->fecha_fin ?? today()->format('Y-m-d'),
                    "user_id" => $user->id,
                    "total" => $total,
                    "estado_id" => 5,
                    "created_at"    => now(),
                    "updated_at"    => now()
                ]);
                $detallesListParaInsertar = [];
                foreach ($habitacionesDB as $hb) {
                    $subtotal = $hb->tipohabitacion->precio_base;
                    $total += $subtotal;

                    $detallesListParaInsertar[] = [
                        "reserva_id"    => $reserva->id,
                        "habitacion_id" => $hb->id,
                        "subtotal"      => $subtotal,
                        "estado_id" => 5,
                        "created_at"    => now(),
                        "updated_at"    => now()
                    ];

                    $hb->update(["estado_id" => 2]);
                }
                //Usamos DetalleReserva::insert($array) para hacer una sola consulta a la base de datos en lugar de hacer un create dentro del bucle (lo cual es lento).
                ReservaDetalle::insert($detallesListParaInsertar);

                $reserva->update(["total" => $total]);

                return response()->json(["message" => "Reservación Registrada Exisotamente", "estado" => 201], 201);
            });
        } catch (\Exception $e) {
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

    public function updateReservacionById(Request $request, Reserva $reserva)
    {
        $request->validate([
            // 'sometimes' permite que el campo no venga en el JSON
            "fecha_ini" => "sometimes|date",
            "fecha_fin" => "sometimes|date",
            "habitaciones" => "sometimes|array|min:1",
            "habitaciones.*" => "exists:habitaciones,id"
        ]);
        try {
            return DB::transaction(function () use ($request, $reserva) {
                if ($request->has("habitaciones")) {
                    $antiguasIds = $reserva->detalles->pluck('habitacion_id');
                    Habitaciones::whereIn("id", $antiguasIds)->update(['estado_id' => 1]);

                    $reserva->detalles()->where("estado_id", 5)->update([
                        'estado_id' => 7,
                        'updated_at' => now()
                    ]);
                    $reserva->detalles()->delete();

                    $nuevoTotal = 0;
                    $habitaciones = Habitaciones::whereIn('id', $request->habitaciones)->get();
                    //Creamdo nuevoas detalles
                    foreach ($habitaciones as $hb) {
                        $subtotal = $hb->tipohabitacion->precio_base;
                        $nuevoTotal += $subtotal;

                        $reserva->detalles->create(
                            [
                                'habitacion_id' => $hb->id,
                                'subtotal' => $subtotal,
                            ]
                        );
                        $hb->update(["estado_id" => 2]);
                    }

                    $reserva->total = $nuevoTotal;
                }
                if ($request->has("fecha_ini")) $reserva->fecha_ini = $request->fecha_ini;
                if ($request->has("fecha_fin")) $reserva->fecha_fin = $request->fecha_fin;
                //guardamos los nuevos datos de reserva
                $reserva->save();

                return response()->json(['message' => 'Datos actualizados con éxito'], 200);
            });
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
                Habitaciones::whereIn('id', $habitacionesIds)->update(['estado_id' => 1]); // Disponible

                $reserva->delete();

                return response()->json(['message' => 'Reserva cancelada y habitaciones liberadas']);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
