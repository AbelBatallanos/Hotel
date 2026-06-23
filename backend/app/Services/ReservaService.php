<?php
namespace App\Services;

use App\Http\Requests\Reserva\ReservaUpdateRequest;
use App\Models\Habitaciones;
use App\Models\Reserva;
use App\Models\ReservaDetalle;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class ReservaService{

    public function crearReserva(array $datos,$user){

        return DB::transaction(function()use($datos, $user ){
            $idsHab = collect($datos["habitaciones"])->pluck("id");

            // Nadie más puede modificar estas habitaciones hasta que termine este bloque
            $habitaciones = Habitaciones::with(['tipohabitacion.tarifa'])
                            ->whereIn("id", $idsHab)
                            ->disponiblesEnFecha($datos["fecha_ini"], $datos["fecha_fin"])
                            ->lockForUpdate()
                            ->get();
            
            if ($habitaciones->count() !== $idsHab->count()) {
                // Averiguamos cuáles IDs faltan exactamente
                $idsEncontrados = $habitaciones->pluck('id')->toArray();

                $idsFaltantes = array_diff($idsHab->toArray(), $idsEncontrados);
                throw new \Exception("Las siguientes habitaciones no existen o ya no están disponibles: " . implode(', ', $idsFaltantes), 404);
            }
            // foreach($habitaciones as $hab){
            //     if($hab->id_estado != 1){
            //         throw new Exception("La habitación {$hab->num_habitacion} se encuentra reservada.", 409);
            //     }
            // }

            $reserva = Reserva::create([
                "fecha_ini" => $datos['fecha_ini'] ?? today()->format('Y-m-d'),
                "fecha_fin" => $datos['fecha_fin'] ?? today()->format('Y-m-d'),
                "id_cliente" => $this->resolverIdCliente($user, $datos),
                "id_recepcion" => $this->resolverIdRecepcion($user), 
                "origen_reserva" => $datos['origen_reserva'] ?? 'web',
                "total" => 0, 
                "estado_id" => 5,
            ]);
            $total=0;
            $detallesreserva =[];

            foreach($habitaciones as $hab){
                $subtotal = $hab->tipohabitacion->calcularSubtotal($reserva->fecha_ini);
                $total += $subtotal;

                $detallesreserva[]= [
                    "reserva_id"=> $reserva->id,
                    "habitacion_id"=> $hab->id,
                    "subtotal" => $subtotal,
                    "estado_id" => 5,
                    "created_at"    => now(),
                    "updated_at"    => now()
                ];

                $hab->update(["id_estado" => 2]);
            }
            ReservaDetalle::insert($detallesreserva);
            
            $reserva->update(["total"=> $total]);
           
        });
    }

    public function verMisReservas($request, $user){
        $query = Reserva::with(["detalles.habitacion.tipohabitacion"]);
        $misreservas="";
        if($user->IsRecepcionista()){
        
            if(!$request->has("id_cliente") || empty($request->query("id_cliente"))){
                throw new \Exception("El parámetro 'id_cliente' es obligatorio para el rol de recepcionista.", 400);
            }
            $query->reservaCliente($request->query("id_cliente"));
        }
        else{
            $query->reservaCliente($user->id);
        }
        $misreservas = $query->latest()->get();
        return $misreservas;
    }


    public function actualizarReserva(ReservaUpdateRequest $request, Reserva $reserva){
            DB::transaction(function()use($request, $reserva){
                if($request->has("habitaciones")){
                    $fechaIni = $reserva->fecha_ini;
                    $fechaFin = $reserva->fecha_fin;

                    $IdsHabsSolicitadas  = collect($request["habitaciones"])->pluck("id");
                    $habActuales = $reserva->detalles->pluck("habitacion_id")->toArray();

                    $habitacionesNuevas = $IdsHabsSolicitadas->diff($habActuales);

                    $habsDisponibles  = Habitaciones::multiplesHabitaciones($habitacionesNuevas)
                    ->disponiblesEnFecha($fechaIni,$fechaFin)
                    ->get();

                    if($habsDisponibles->count() !== $habitacionesNuevas->count()){
                        $IdsHabEncontrados = $habsDisponibles->pluck("id")->toArray();
                        $idsFaltantes = $habitacionesNuevas->diff($IdsHabEncontrados);

                         throw new Exception("Las siguientes habitaciones ya están ocupadas: " . implode(", ", $idsFaltantes->toArray()), 409);
                    }

                //Falta aun implementar
                } 
            });
    }

    public function cancelarReserva(Reserva $reserva){
        return DB::transaction(function()use($reserva){

            $habIds = $reserva->detalles->pluck("habitacion_id")->toArray();
            Habitaciones::multiplesHabitaciones($habIds)->updateFields(["id_estado"=>1]);//Disponible

            $reserva->update(["estado_id"=>7]);
            $reserva->detalles()->update(["estado_id"=>7]);//Cancelado
            $reserva->detalles()->delete();
            $reserva->delete();
        });
    }



    private function resolverIdCliente($user, $fields):int{

        if($user->IsCliente()){
            return $user->id;
        }

        if(!isset($fields["id_cliente"])){
            throw new Exception("Es obligatorio proporcionar un id_cliente.", 422);
        }
        return $fields["id_cliente"];
    }

    private function resolverIdRecepcion($user)
    {
        // Solo asignamos si es Recepcionista (rol 2)
        return ($user->rol_id == 2) ? $user->id : null;
    }


}







?>
