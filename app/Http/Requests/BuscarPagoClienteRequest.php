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
            'tipo_busqueda' => $this->input('tipo_busqueda', 'dni'),
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

            if ($valorBusqueda === '') {
                return;
            }

            if ($this->input('tipo_busqueda') === 'dni' && ! ctype_digit($valorBusqueda)) {
                $validator->errors()->add('valor_busqueda', 'Para buscar por DNI debe ingresar solo numeros.');
            }
        });
    }
}
