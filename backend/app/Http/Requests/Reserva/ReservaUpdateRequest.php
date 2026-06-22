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
<<<<<<< HEAD
            "fecha_ini" => "required|date|date_format:Y-m-d",
            "fecha_fin" => "required|date|date_format:Y-m-d|after_or_equal:fecha_ini",
            "habitaciones" => "nullable|array|min:1",
            "habitaciones.*.id" => "nullable|integer|exists:habitaciones,id,deleted_at,NULL",
        ];
    }


    public function messages()
    {
        return [
            "fecha_ini.required" => "Es requerido este campo",
            "fecha_ini.date" => "Debe ser el dato en formato fecha",
            "fecha_fin.required" => "Es requerido este campo",
            "fecha_fin.date" => "Debe ser el dato en formato fecha",

=======
            "fecha_ini" => "sometimes|date",
            "fecha_fin" => "sometimes|date",
            "habitaciones" => "sometimes|array|min:1",
            "habitaciones.*.id" => "numeric|exists:habitaciones,id",
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)
        ];
    }
}
