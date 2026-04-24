<?php

namespace App\Http\Requests\Reserva;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\CssSelector\Node\FunctionNode;

class ReservaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->rol() && in_array($this->user()->rol->nombre, ["cliente", "recepcionista"]);
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
