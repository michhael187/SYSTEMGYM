<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera luego desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para registrar un nuevo cliente.
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'integer', 'unique:clientes,dni'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:255'],
            'membresia_actual_id' => ['required', 'exists:membresias,id'],
            'fecha_ultimo_pago' => ['required', 'date'],
            'fecha_vencimiento' => ['required', 'date'],
            'peso' => ['nullable', 'numeric', 'between:0,999.99'],
            'altura' => ['nullable', 'numeric', 'between:0,999.99'],
            'observaciones' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ];
    }
}
