<?php

namespace App\Http\Requests\Tarea;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTareaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        // Sanitizar entradas antes de validar
        $this->merge([
            'descripcion' => isset($this->descripcion) ? strip_tags($this->descripcion) : null,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "descripcion" => "required|string|regex:/^[a-zA-Z0-9\s]+$/",
            "fecha_limite" => "required|date_format:Y-m-d H:i:s",
            "id_empleado" => "required|numeric|exists:empleados,id",
        ];
    }

    public function messages()
    {
        return [
            "descripcion.required" => "El descripcion es obligatorio",
            "descripcion.string" => "El campo descripcion solo debe de ser texto",
            'descripcion.regex' => 'El descripcion solo puede contener letras, números y espacios.',
            "fecha_limite.required" => "La fecha_limite es obligatorio",
            "id_empleado.required" => "El id_empleado es obligatorio",
        ];
    }
}
