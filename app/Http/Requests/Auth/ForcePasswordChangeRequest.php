<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ForcePasswordChangeRequest extends FormRequest
{
    /**
     * El usuario ya fue autenticado por la ruta protegida.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para completar el cambio obligatorio de contrasena.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ];
    }

    /**
     * Mensajes amigables para el formulario de cambio obligatorio.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Ingresa una nueva contrasena para continuar.',
            'password.string' => 'La contrasena ingresada no es valida.',
            'password.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmacion de la contrasena no coincide.',
        ];
    }
}
