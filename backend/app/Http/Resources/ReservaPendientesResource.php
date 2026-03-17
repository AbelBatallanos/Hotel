<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaPendientesResource extends JsonResource
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
            "usuario" => new UserResumenResource($this->user),
            "total" => $this->total,
            "fecha_ini" => $this->fecha_ini,
            "fecha_fin" => $this->fecha_fin,
            "total_habitaciones" => $this->detalles->count(),
            "estado" => $this->estado->nombre,
        ];
    }
}
