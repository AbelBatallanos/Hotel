<?php

namespace App\Http\Requests\Reparacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReparacionRequest extends FormRequest
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
            "costo_reparacion" => "nullable|numeric",
            "fecha_resolucion" => "nullable|date",
            "id_estado" => "required|exists:estados,id",
            "id_empleado" => "nullable|exists:empleados,id",
            "id_proveedor" => "nullable|exists:proveedores,id",
        ];
    }
    public function messages()
    {
        return [
            "id_estado.required" => "Debes indicar el estado de la reparación.",
            "costo_reparacion.numeric" => "El costo debe ser un número válido.",
        ];
    }
}
