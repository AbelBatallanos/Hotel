<?php

namespace App\Http\Requests\TiposHabitacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTiposHabitacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "tipo_cama" => "required|string",
            "amenities" => "required|string",
            "capacidad" => "required|numeric",
            "nombre" => "required|string",
            "precio_base" => "required|numeric",
        ];
    }
    public function message()
    {
        return [
            "tipo_cama.required" => "Es Obligatorio darle valor en tipo_cama",
            "amenities.required" => "No puede estar vacio amenities",
            "capacidad.required" => "No debe estar vacio la capacidad",
            "capacidad.numeric" => "Solo debe contener caracter numerico",
            "nombre.required" => "No debe estar vacio nombre",
            "precio_base.required" => "No debe estar vacio precio",
            "precio_base.numeric" => "Solo debe contener caracter numerico",
        ];
    }
}
