<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BuscarPagoClienteRequest extends FormRequest
{
    /**
     * La autorizacion se resuelve desde la policy del controller.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza los filtros antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'tipo_busqueda' => $this->input('tipo_busqueda', 'apellido'),
            'valor_busqueda' => trim((string) $this->input('valor_busqueda', '')),
        ]);
    }

    /**
     * Reglas para la busqueda opcional de clientes dentro del flujo de pagos.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => ['nullable', 'integer', 'exists:clientes,id'],
            'tipo_busqueda' => ['nullable', 'in:dni,apellido'],
            'valor_busqueda' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Valida el contenido del campo cuando se busca por DNI.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $valorBusqueda = $this->input('valor_busqueda');
            $tipoBusqueda = $this->input('tipo_busqueda');

            if ($valorBusqueda === '') {
                return;
            }

            if ($tipoBusqueda === 'dni' && ! preg_match('/^\d{7,8}$/', $valorBusqueda)) {
                $validator->errors()->add('valor_busqueda', 'El DNI debe contener solo numeros y tener entre 7 y 8 digitos.');
            }

            if ($tipoBusqueda === 'apellido' && ! preg_match('/^[\p{L}\s]+$/u', $valorBusqueda)) {
                $validator->errors()->add('valor_busqueda', 'El apellido solo puede contener letras y espacios.');
            }
        });
    }
}
