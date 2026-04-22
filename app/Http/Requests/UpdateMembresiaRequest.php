<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMembresiaRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera luego desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para modificar una membresia.
     */
    public function rules(): array
    {
        $membresia = $this->route('membresia');

        return [
            'nombre_plan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('membresias', 'nombre_plan')->ignore($membresia->id),
            ],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_dias' => ['required', 'integer', 'min:1'],
        ];
    }
}
