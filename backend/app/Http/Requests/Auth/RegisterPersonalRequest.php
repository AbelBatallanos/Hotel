<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class RegisterPersonalRequest extends FormRequest
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
            "name" => "required|string",
            "lastname" => "required|string",
            "email" => "required|email|unique:users,email",
            "password"=> "sometimes|string",
            "ci" =>  "required|string",
            "rol" => "required|numeric|exists:roles,id",
            "turno" => "required|numeric|exists:turnos,id",
            "sueldo" => "sometimes|decimal",
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "name.required" => "El campo name es obligatorio",
            "name.string" => "Debe de ser valor cadena de texto",

            "lastname.required" => "El campo lastname es obligatorio",
            "lastname.string" => "Debe de ser valor cadena de texto",

            "password.string"=> "Debe de ser valor texto",

            "email.required" => "El campo email es obligatorio",
            "email.email" => 'El campo email debe ser de valor email',
            "email.unique" => 'El correo ya existe, introdusca otro nuevo',
            
            "ci.required"=> "El campo ci es obligatorio",
            "ci.string" => "Debe de ser valor cadena de texto",

            "rol.required" => "El campo rol es obligatorio",
            "rol.numeric" => "Debe de ser valor numerico",
            "rol.exists" => "El rol dado, debe de existir",
            
            "turno.required" => "El campo turno es obligatorio",
            "turno.numeric" => "Debe de ser valor numerico",
            "turno.exists" => "El rol dado, debe de existir",

            "sueldo.decimal" => "Debe de ser valor decimal",
        ];
    }

}
