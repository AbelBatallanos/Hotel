<?php

namespace App\Http\Requests\Habitacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UpdateHabitacionRequest extends FormRequest
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
            // Al usar Rule, pasamos la regla de un string a un array
            "num_habitacion" => [
                "sometimes",
                "string",
                Rule::unique('habitaciones', 'num_habitacion')->ignore($this->route('habitacion'))
            ],
            // "capacidad" => "sometimes|integer",
            "id_tipo_habitacion" => "sometimes|exists:tipos_habitacion,id",
            "id_estado" => "sometimes|exists:estados,id",
            "imagen"=> "sometimes|image|mimes:jpg,jpge,png,webp|max:2048"
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "num_habitacion.string" => "El num_habitacion debe ser una cadena de texto.",
            "num_habitacion.max" => "El num_habitacion no puede tener más de 20 caracteres.",
            
            // "capacidad.integer" => "La capacidad debe ser un número entero.",
            // "capacidad.min" => "La capacidad mínima es de 1 persona.",

            "tipo_habitacion_id.exists" => "El tipo de habitación seleccionado no existe en el sistema.",
            "id_estado.exists" => "El estado seleccionado no es válido.",
        
            "imagen.max"  => "La imagen no debe pesar más de 2MB.",
            "imagen.image"   => "El archivo seleccionado debe ser una imagen válida.",
            "imagen.mimes"   => "La imagen debe tener un formato válido: jpg, jpeg, png o webp.",   

            ];
    }
}
