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
            "tipohabitacion" => [
                "nombre" => $this->tipohabitacion->nombre ?? null,
                "amenities" => $this->tipohabitacion->amenities ?? null,
                "tipo_cama" => $this->tipohabitacion->tipo_cama ?? null,
                "numero_habitacion" => $this->num_habitacion ?? null,
                "capacidad" => $this->tipohabitacion->capacidad ?? null,
                "precio" => $this->tipohabitacion->precio_base ?? null

            ],

            "estado" => $this->estado->nombre ?? null,
            "imagen" => $this->imagen ?? null,

        ];
    }
}
