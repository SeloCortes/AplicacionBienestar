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
            'identificacion'  => 'required|digits_between:1,20|unique:users,identificacion',
            'correo'          => 'required|string|email|max:255|unique:users,correo',
            'password'        => 'required|string|min:8|confirmed',
            'telefono'        => 'nullable|digits_between:1,10',
            'genero'          => 'nullable|string|max:50',
            'etnia'           => 'nullable|string|max:50',
            'discapacidad'    => 'nullable|string|max:255',
            
            // Rol selector ('Estudiante' or 'Tercero')
            'rol'             => 'required|string|in:Estudiante,Tercero',
            
            // Campos específicos de Estudiante
            'facultad'        => 'required_if:rol,Estudiante|nullable|string|max:255',
            'nombre_carrera'  => 'required_if:rol,Estudiante|nullable|string|max:255',
            'semestre'        => 'required_if:rol,Estudiante|nullable|integer|min:1|max:20',
            
            // Campos específicos de Tercero
            'estamento'       => 'required_if:rol,Tercero|nullable|string|max:255',
        ];
    }
}
