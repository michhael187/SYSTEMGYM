<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReactivateUserRequest extends FormRequest
{
    /**
     * La autorizacion se resuelve desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para la reactivacion de usuarios.
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
