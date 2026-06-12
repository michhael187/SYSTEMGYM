<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'membresia_id' => ['required', 'exists:membresias,id'],
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
            // Errores para el Cliente
            'cliente_id.required' => 'Debes seleccionar un cliente de la lista antes de cobrar.',
            'cliente_id.exists' => 'El cliente seleccionado no es válido o fue eliminado.',

            // Errores para la Membresía
            'membresia_id.required' => 'Por favor, elige qué plan o membresía estás cobrando.',
            'membresia_id.exists' => 'El plan seleccionado no se encuentra en el sistema.',

            // Errores para la Fecha
            'fecha_pago.required' => 'La fecha y hora del pago son obligatorias.',
            'fecha_pago.date' => 'El formato de la fecha ingresada no es correcto.',
        ];
    }
}
