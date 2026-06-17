<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePagoRequest extends FormRequest
{
    /**
     * La autorizacion se resolvera luego desde la Policy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para registrar un nuevo pago.
     */
    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'membresia_id' => [
                'required',
                Rule::exists('membresias', 'id')
                    ->where('activo', true)
                    ->whereNull('deleted_at'),
            ],
            'fecha_pago' => ['required', 'date'],
        ];
    }

    /**
     * Mensajes de error personalizados y amigables.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cliente_id.required' => 'Debes seleccionar un cliente de la lista antes de cobrar.',
            'cliente_id.exists' => 'El cliente seleccionado no es valido o fue eliminado.',
            'membresia_id.required' => 'Por favor, elige que plan o membresia estas cobrando.',
            'membresia_id.exists' => 'La membresia seleccionada no es valida o ha sido dada de baja.',
            'fecha_pago.required' => 'La fecha y hora del pago son obligatorias.',
            'fecha_pago.date' => 'El formato de la fecha ingresada no es correcto.',
        ];
    }
}
