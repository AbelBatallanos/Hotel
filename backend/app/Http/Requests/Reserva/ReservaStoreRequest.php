<?php

namespace App\Http\Requests\Reserva;

use App\Rules\HabitacionDisponible;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class ReservaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && in_array($user->rol_id, [1,2,3]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "origen_reserva" => "sometimes|string",
            "fecha_ini" => "required|date",
            "fecha_fin" => "required|date|after:fecha_ini",

            "habitaciones" => "required|array|min:1",
            "habitaciones.*.id" => [
                "required",    
                "integer",
                "exists:habitaciones,id",
                new HabitacionDisponible($this->fecha_ini, $this->fecha_fin),
                ],
            
            "id_cliente" => "sometimes|numeric|exists:users,id"
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "fecha_ini.required"=> "La fecha de inicio es obligatoria",
            "fecha_ini.date" => "La fecha de inicio debe de ser una fecha",

            "fecha_fin.after" => "La fecha de finalización debe ser posterior a la fecha de inicio.",

            "id_cliente.numeric"=> "EL cliente debe de ser numerico",
            "id_cliente.exists"=> "El cliente dado no existe",


            "habitaciones.required" => "Debes seleccionar al menos una habitación.",
            "habitaciones.array"    => "El formato de habitaciones debe ser una lista.",
            "habitaciones.min"      => "Debes seleccionar mínimo 1 habitación.",
            
            "habitaciones.*.id.required" =>  "Cada habitación debe enviarse como un objeto con la clave 'id'. Ejemplo: {\"id\":3}",
            "habitaciones.*.id.integer"  => "El campo 'id' de cada habitación debe ser un número.",
            "habitaciones.*.id.exists"   => "Una de las habitaciones seleccionadas no existe en el sistema."
        ];
    }
}
