<?php

namespace App\Http\Requests\Reserva;

use App\Rules\HabitacionDisponible;
use Illuminate\Foundation\Http\FormRequest;
<<<<<<< HEAD
use Symfony\Component\CssSelector\Node\FunctionNode;
=======
use Override;
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)

class ReservaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
<<<<<<< HEAD
        return $this->user() && $this->user()->rol() && in_array($this->user()->rol->nombre, ["cliente", "recepcionista"]);
        // return true;
=======
        $user = $this->user();
        return $user && in_array($user->rol_id, [1,2,3]);
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)
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
            "origen_reserva" => "nullable|string",
            "fecha_ini" => "required|date|date_format:Y-m-d",
            "fecha_fin" => "required|date|date_format:Y-m-d|after_or_equal:fecha_ini",
            "habitaciones" => "required|array|min:1",
            "habitaciones.*.id" => "required|integer|exists:habitaciones,id,deleted_at,NULL",

        ];
    }
    //    "id_cliente" => "required_if:rol_id,2|numeric|exists:clientes,id"

    public function messages()
    {
        return [
            "origen_reserva.string" => "origen_reserva debe recivir solo texto",
            "fecha_ini.required" => "Debes mandar la fecha inicial",
            "fecha_ini.date" => "Debes ser en formato fecha",
            "fecha_ini.date_format" => "No tiene el formato correcto: Debe de ser Y-m-d H:m:s",
            "fecha_fin.required" => "Debes mandar la fecha inicial",
            "fecha_fin.date" => "Debes ser en formato fecha",
            "fecha_fin.date_format" => "No tiene el formato correcto: Debe de ser Y-m-d H:m:s",
            "habitaciones.required" => "No puede estar vacio",
            "habitaciones.min" => "Debes mandar al menos 1 habitación",
            "habitaciones.*.id.required" => "Cada habitación debe incluir un id",
            "habitaciones.*.id.integer" => "El id de la habitación debe ser numérico",
            "habitaciones.*.id.exists" => "La habitación indicada no existe o fue eliminada",
=======
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
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)
        ];
    }
}
