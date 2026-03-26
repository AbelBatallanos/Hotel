<?php

namespace App\Http\Requests\Servicio;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreServicioRequest extends FormRequest
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
            'nombre' => isset($this->nombre) ? strip_tags($this->nombre) : null,
            'costo_unit' => isset($this->costo_unit) ? preg_replace('/[^\d\.\-]/', '', $this->costo_unit) : null,
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
            "costo_unit" => "required|numeric|min:0",
            "nombre" => "required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/",
            "id_departamento" => "required|numeric|exists:departamentos,id",
        ];
    }

    public function messages()
    {
        return [
            "costo_unit.required" => "El costo es obligatorio",
            "costo_unit.numeric" => 'El costo debe ser un número válido.',
            "costo_unit.min" =>  'El costo debe ser mayor o igual a 0.',

            "nombre.required" => "El nombre es obligatorio",
            "nombre.string" => "El campo nombre solo debe de ser texto",
            'nombre.max' => 'El nombre no puede exceder :max caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras, números y espacios.',

            'id_departamento.required' => 'El departamento es obligatorio.',
            'id_departamento.integer' => 'El id del departamento debe ser un número entero.',
            'id_departamento.exists' => 'El departamento seleccionado no existe.',
        ];
    }

    public function attributes(): array
    {
        // Nombres legibles para los campos en los mensajes
        return [
            'costo_unit' => 'costo',
            'id_departamento' => 'departamento',
        ];
    }
}
