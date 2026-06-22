<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginAuthRequest extends FormRequest
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
            "email" => 'required|email|exists:users,email',
            "password" => 'required|string',
        ];
    }
    #[Override]
    public function messages()
    {
        return[
            "email.required"=> "El campo email es obligatorio",
            "email.exists"=> "Ese email esta en uso, ingresa uno diferente",
            "email.email" => "El valor debe de ser un tipo email",

            "password.required"=> "El campo password es obligatorio",
            "password.string"=> "Debe de ser valor texto",
        ];
    }
}
