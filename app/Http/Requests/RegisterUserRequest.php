<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_apellido' => 'required|string|max:255',
            'identificacion'  => 'required|string|max:50|unique:users,identificacion',
            'correo'          => 'required|email|unique:users,correo',
            'password'        => 'required|string|min:8|confirmed',
            'telefono'        => 'nullable|string|max:20',
            'genero'          => 'nullable|string|max:50',
            'etnia'           => 'nullable|string|max:50',
            'discapacidad'    => 'boolean',
        ];
    }
}
