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
use App\Models\Tarifa;
use App\Services\HabitacionService;
use App\Services\ReservaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\Clock\now;

class ReservaController extends Controller
{
    protected $reservaService;
    protected $habitacionService;

    public function __construct(ReservaService $_reservaService, HabitacionService $_habService)
    {
        $this->reservaService = $_reservaService;
        $this->habitacionService = $_habService;
    }

    public function getMisReservaciones(Request $request)
    { //cliente
        try {
            
            $misreservas = $this->reservaService->verMisReservas($request, $request->user());

            if ($misreservas->isEmpty()) {
                return response()->json([
                    "mensaje" => "No se encontraron reservaciones."
                ], 404);
            }

            return response()->json(["reservas" => ReservaResource::collection($misreservas)]);
        } catch (\Throwable $th) {
            Log::error("Error en getMisReservas" . $th->getMessage());
            $code = $th->getCode() === 400 ? 400 : 500;
            $mensaje = $code === 400 ? $th->getMessage() : "Error en el servidor";
            
            return response()->json(["error" => $mensaje], $code);
        }
    }

    public function geAllReservaciones() 
    {
        $reservaciones_pendientes = Reserva::pendientes()->detallesPendientes()->get();
        $reservaciones_ocupados = Reserva::ocupados()->detallesOcupados()->get();
        return response()->json([
            "Pendientes" => ReservaPendientesResource::collection($reservaciones_pendientes),
            "Ocupados" => ReservaOcupadosResource::collection($reservaciones_ocupados),
        ], 200);
    }


    public function storeReservacion(ReservaStoreRequest $request)
    {
        Log::info('Datos recibidos en storeReservacion:', $request->all());
        $fields = $request->validated();

        try {
            $this->reservaService->crearReserva($fields, $request->user());
            
            return response()->json(["message" => "Reservación Registrada Exisotamente"], 201);
        }catch (\Exception $e) {
            Log::error('Error en reserva: ' , ["file"=> $e->getFile(), "linea"=> $e->getLine(), "mensaje"=>$e->getMessage()]);
            if  ($e->getCode() == 404){
                return response()->json(['error' => $e->getMessage()], 404);
            }
            if ($e->getCode() == 409) {
                return response()->json(['error' => $e->getMessage()], 409);
            }
            return response()->json(['error' => 'Error interno al procesar la reserva'], 500);
        }
    }// 

    public function showReservaDetalles(Reserva $reserva)
    {
        $reserva->load(["detalles" => function ($query) {
                                            $query->where("estado_id", 5);
                                        }
        ]);
        return response()->json([
            "reserva" => new ReservaGeneralResource($reserva),
        ], 200);
    }

    public function updateReservacionById(ReservaUpdateRequest $request, Reserva $reserva)
    {
        $fields =$request->validated();
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
                    $habitIds = collect($request->habitaciones)->pluck("id");
                    $habitaciones = Habitaciones::whereIn('id', $habitIds)->get();

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

    public function destroy($id)
    {
        try {
            $reserva = Reserva::find($id);
            if (!$reserva) {
                return response()->json(['error' => 'La reserva no existe'], 404);
            }   
            $this->reservaService->cancelarReserva($reserva);
            return response()->json(['message' => 'Reserva cancelada y habitaciones liberadas']);
            
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => "La reserva con id {$id} no existe"], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        };
    }
}
