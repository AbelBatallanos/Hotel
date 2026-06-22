<?php

namespace App\Http\Requests\Habitacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreHabitacionRequest extends FormRequest
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
            "num_habitacion" => "required|unique:habitaciones,num_habitacion",
            "id_tipo_habitacion" => "required|exists:tipos_habitacion,id",
            "imagen" => "required|image|mimes:jpg,jpeg,png,webp|max:2048"
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "num_habitacion.required"=> "El campo num_habitacion es obligatorio", 
            "num_habitacion.unique"=> "El ya existe ese numero de habitacion, ingresa otro nueva", 

            "id_tipo_habitacion.required"=> "El campo id_tipo_habitacion es obligatorio", 
            "id_tipo_habitacion.exists"=> "El tipo habitacion no existe, ingresa otro nuevamente", 

            "imagen.image"   => "El archivo seleccionado debe ser una imagen válida.",
            "imagen.mimes"   => "La imagen debe tener un formato válido: jpg, jpeg, png o webp.",   

            "imagen.max"     => "La imagen no debe pesar más de 2MB.",
            "imagen.required"=> "Es obligatorio subir una imagen para la habitación."
        ];
    }
}
