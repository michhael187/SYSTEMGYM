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
     */
    public function rules(): array
    {
        $usuario = $this->route('usuario');

        return [
            'rol' => ['required', 'string', Rule::in(RolUsuario::gestionablesValues())],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($usuario->id),
            ],
            'estado' => ['required', 'boolean'],
        ];
    }
}
