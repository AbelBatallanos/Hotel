<?php

namespace App\Http\Requests\TiposHabitacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoHabitacionRequest extends FormRequest
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
            "tipo_cama" => "nullable|string",
            "amenities" => "nullable|string",
            "capacidad" => "nullable|numeric",
            "nombre" => "nullable|string",
            "precio_base" => "nullable|numeric",
        ];
    }

    public function messages()
    {
        return [];
    }
}
