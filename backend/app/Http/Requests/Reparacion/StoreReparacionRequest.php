<?php

namespace App\Http\Requests\Reparacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\CssSelector\Node\FunctionNode;

class StoreReparacionRequest extends FormRequest
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
            "detalle_averia" => "required|string",
            "id_habitacion" => "required|numeric|exists:habitaciones,id",
            "id_estado" => "required|numeric|exists:estados,id",
            "costo_reparacion" => "nullable|numeric",
            "fecha_resolucion" => "nullable|date",
            "id_empleado" => "nullable|numeric|exists:empleados,id",
            "id_proveedor" => "nullable|numeric|exists:proveedores,id",
        ];
    }

    public function message()
    {
        return [
            "detalle_averia.required" => "Debe contener algo",
            "detalle_averia.string" => "Debe ser tipo texto",
            "id_habitacion.required" => "Debe agregar la habitación",
            "id_habitacion.numeric" => "Debe ser tipo numerico",
            "id_habitacion.exists" => "Debe existir esa habitacion",
            "id_estado.required" => "Debe agregar el estado",
            "id_estado.numeric" => "Debe ser tipo numerico",
        ];
    }
}
