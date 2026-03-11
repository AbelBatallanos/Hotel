<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HabitacionResource extends JsonResource
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
            "codigo" => $this->codigo,
            "descripcion" => $this->descripcion,
            "capacidad" => $this->capacidad,
            "estado" => $this->estado->nombre ?? null,
            "imagen" => $this->imagen,
            "tipo_habitacion" => $this->tipohabitacion->nombre ?? null,
            "precio" => $this->tipohabitacion->precio_base ?? null
        ];
    }
}
