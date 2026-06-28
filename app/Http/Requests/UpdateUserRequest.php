<?php

namespace App\Http\Requests;

use App\Enums\RolUsuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * La autorizacion se resuelve desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para la modificacion de usuarios.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $usuario = $this->route('usuario');

        return [
            'rol' => ['required', 'string', Rule::in(RolUsuario::gestionablesValues())],
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($usuario->id),
            ],
        ];
    }

    /**
     * Mensajes personalizados de validacion.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
        ];
    }
}
