<?php

namespace App\Http\Requests;

use App\Enums\RolUsuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera con Policy, no desde el Request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para el alta de usuarios del sistema.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            // Solo se permiten los roles operativos definidos para esta etapa.
            'rol' => ['required', 'string', Rule::in(RolUsuario::gestionablesValues())],

            // El DNI identifica al usuario y no debe repetirse.
            'dni' => ['required', 'regex:/^[0-9]+$/', 'unique:usuarios,dni'],

            'nombre' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],

            // El email debe ser valido y unico dentro de usuarios.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],

            // Se exige una clave temporal minima para el primer acceso.
            'password' => ['required', 'string', 'min:8'],

            'estado' => ['required', 'boolean'],
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
            'dni.regex' => 'El DNI solo puede contener números.',
        ];
    }
}
