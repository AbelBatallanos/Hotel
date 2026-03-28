<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            "nombre" => $this->tipohabitacion->nombre,
            "amenities" => $this->tipohabitacion->amenities,
            "tipo_cama" => $this->tipohabitacion->tipo_cama,
            "numero_habitacion" => $this->num_habitacion,
            "capacidad" => $this->tipohabitacion->capacidad,
            "estado" => $this->estado->nombre ?? null,
            "imagen" => $this->imagen,
            "tipo_habitacion" => $this->tipohabitacion->nombre ?? null,
            "precio" => $this->tipohabitacion->precio_base ?? null
        ];
    }
}
