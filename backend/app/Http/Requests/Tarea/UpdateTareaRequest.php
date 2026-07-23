<?php

namespace App\Http\Requests\Tarea;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "descripcion" => "sometimes|string",
            "fecha_limite" => "sometimes|date_format:Y-m-d H:i:s",
            "empleado" => "sometimes|exists:empleado,id",
            "estado" => "sometimes|exists:estado,id",
            "cargo" => "sometimes|numeric|exists:roles,id",
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "descripcion.string" => "El campo descripcion solo debe de ser texto",
            'descripcion.regex' => 'La descripcion solo puede contener letras, números y espacios.',
            
            "fecha_limite.date_format" => "No tiene el formato correcto: Debe de ser Y-m-d H:m:s",
            
            "id_empleado.numeric" => "Debe de ser valor numerico",
            "id_empleado.exists" => "No existe el usuario seleccionado",
            
            "cargo.exists" => "El cargo seleccionado debe de existir",
        ];
    }
}
