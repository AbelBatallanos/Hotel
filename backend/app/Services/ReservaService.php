<?php

namespace App\Services;

use App\Models\Habitaciones;
use App\Models\Reserva;
use App\Models\ReservaDetalle;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReservaService
{
    public function procesarReserva(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $idsHabitaciones = collect($data["habitaciones"])->pluck("id");

            // PESSIMISTIC LOCKING: Bloqueamos las habitaciones para evitar doble reserva
            $habitacionsDB = Habitaciones::with("tipohabitacion")->whereIn("id", $idsHabitaciones)
                ->lockForUpdate()
                ->get();

            $faltantes = $idsHabitaciones->diff($habitacionsDB->pluck("id"));
            if ($faltantes->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'habitaciones' => ['Algunas habitaciones no existen: ' . $faltantes->join(',')]
                ]);
            }

            $ocupados = $habitacionsDB->where("id_estado", 2);
            if ($ocupados->isNotEmpty()) {
                throw new Exception('Algunas habitaciones ya están ocupadas: ' . $ocupados->pluck('id')->join(','));
            }

            $idCliente = ($user && $user->rol_id == 3 && $user->cliente) ? $user->cliente->id : ($data['id_cliente'] ?? null);
            $idRecepcion = ($user && $user->rol_id == 2 && $user->empleado) ? $user->empleado->id : null;

            $reserva = Reserva::create([
                "fecha_ini" => $data["fecha_ini"],
                "fecha_fin" => $data['fecha_fin'] ?? today()->format('Y-m-d'),
                "id_cliente" => $idCliente,
                "id_recepcion" => $idRecepcion,
                "origen_reserva" => $data['origen_reserva'] ?? null,
                "total" => 0,
                "estado_id" => 5,
            ]);

            $total = 0;
            $detallesList = [];

            foreach ($habitacionsDB as $hb) {
                $descuento = optional($hb->tipohabitacion)->montoDescuento($data['fecha_ini']) ?? 0;
                $subtotal =  max(0, $hb->tipohabitacion->precio_base - ($descuento));
                $total += $subtotal;

                //Seria  importante implement campo descuento por si se aplica uno, saber su  monto del descuento
                $detallesList[] = [
                    "reserva_id" => $reserva->id,
                    "habitacion_id" => $hb->id,
                    "subtotal" => $subtotal,
                    "estado_id" => 5,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            ReservaDetalle::insert($detallesList);

            Habitaciones::whereIn('id', $idsHabitaciones)->update(['id_estado' => 2]);

            $reserva->update(['total' => $total]);

            return $reserva;
        });
    }
}
