<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class RegisterAuthRequest extends FormRequest
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
            "name" => 'required|string',
            "lastname" => 'required|string',
            "email" => 'required|email|unique:users,email',
            "ci" => 'required|string|unique:users,ci', 
            "password" => 'required|string',
            "rol_id" => 'required|exists:roles,id',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "name.required" => "El campo name es obligatorio",
            "name.string" => "El campo name solo debe de ser texto",
            'name.max' => 'El name no puede exceder :max caracteres.',
            'name.regex' => 'El name solo puede contener letras, números y espacios.',
            
            "lastname.required" => "El campo lastname es obligatorio",
            "lastname.string" => "El campo lastname solo debe de ser texto",
            
            "ci.required" => "El campo ci es obligatorio",
            "ci.string" => "El campo ci solo debe de ser texto",
            "ci.unique" => "El valor dado ya existe",
            
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser de valor email',
            'email.unique' => 'El correo ya existe, introdusca uno nuevo',
            
            'password.required' => 'El campo password es obligatorio',
            'password.string' => 'El campo password debe de ser valor texto',
            
            'rol_id.required' => 'El campo rol_id es obligatorio',
            'rol_id.integer' => 'El campo rol debe ser valor numerico',
            'rol_id.exists' => 'El rol no existe',
        ];
    }
}
