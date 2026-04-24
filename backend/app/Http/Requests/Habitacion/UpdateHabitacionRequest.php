<?php

namespace App\Http\Requests\Habitacion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            "num_habitacion" => "sometimes|string",
            "id_tipo_habitacion" => "sometimes|exists:tipos_habitacion,id",
            "estado_id" => "sometimes|exists:estados,id"
        ];
    }


    public function passedValidation()
    {
        $allowed = ["num_habitacion", "id_tipo_habitacion", "estado_id"];
        $extraKeys = array_diff(array_keys($this->all()), $allowed);

        if ($extraKeys) {
            throw ValidationException::withMessages([
                'extra' => ["Campos no permitidos: " . implode(", ", $extraKeys)]
            ]);
        }
    }
}
