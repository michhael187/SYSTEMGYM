<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetupAdminRequest extends FormRequest
{
    /**
     * El setup inicial debe poder ejecutarse sin autenticacion previa.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para crear el primer administrador del sistema.
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'integer', 'unique:usuarios,dni'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
