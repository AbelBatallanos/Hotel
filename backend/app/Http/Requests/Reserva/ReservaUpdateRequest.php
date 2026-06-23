<?php

namespace App\Http\Requests\Reserva;

use Illuminate\Foundation\Http\FormRequest;

class ReservaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->rol() && in_array($this->user()->rol->nombre, ["cliente", "recepcionista"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fecha_ini" => "sometimes|date",
            "fecha_fin" => "sometimes|date",
            "habitaciones" => "sometimes|array|min:1",
            "habitaciones.*.id" => "numeric|exists:habitaciones,id",
        ];
    }
}
