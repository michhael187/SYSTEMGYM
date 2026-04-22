<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembresiaRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera luego desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para registrar una nueva membresia.
     */
    public function rules(): array
    {
        return [
            'nombre_plan' => ['required', 'string', 'max:255', 'unique:membresias,nombre_plan'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_dias' => ['required', 'integer', 'min:1'],
        ];
    }
}
