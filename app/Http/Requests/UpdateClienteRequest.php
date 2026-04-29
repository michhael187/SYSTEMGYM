<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera luego desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para la modificacion de clientes.
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:255'],
            'membresia_actual_id' => ['required', 'exists:membresias,id'],
            'fecha_ultimo_pago' => ['required', 'date'],
            'peso' => ['nullable', 'numeric', 'between:0,999.99'],
            'altura' => ['nullable', 'numeric', 'between:0,999.99'],
            'observaciones' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ];
    }
}
