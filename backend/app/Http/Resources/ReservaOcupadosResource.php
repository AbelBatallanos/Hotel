<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaOcupadosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "origen_reserva" => $this->origen_reserva,
            "cliente" => $this->cliente->user->name,
            "recepcionista" => $this->empleado->user->name ?? null,
            "fecha_ini" => $this->fecha_ini,
            "fecha_fin" => $this->fecha_fin,
            "total" => $this->total,
            "detalles" => ReservaDetallesResource::collection($this->detalles),
            "estado" => $this->estado->nombre,
        ];
    }
}
