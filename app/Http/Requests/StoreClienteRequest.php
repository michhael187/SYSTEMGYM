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
     * Normaliza el campo estado antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'estado' => $this->normalizarEstado($this->input('estado')),
        ]);
    }

    /**
     * Reglas de validacion para registrar un nuevo cliente.
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'integer', 'min:0', 'unique:clientes,dni'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'integer', 'min:0'],
            'peso' => ['nullable', 'numeric', 'between:0,999.99'],
            'altura' => ['nullable', 'numeric', 'between:0,999.99'],
            'observaciones' => ['nullable', 'string'],
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
            'dni.min' => 'El DNI no puede ser negativo.',
            'telefono.min' => 'El número de teléfono no puede ser negativo.',
        ];
    }

    /**
     * Convierte variantes comunes de estado a booleano.
     */
    private function normalizarEstado(mixed $estado): bool|null
    {
        if (is_bool($estado)) {
            return $estado;
        }

        if (is_int($estado)) {
            return $estado === 1;
        }

        if (is_string($estado)) {
            return match (strtolower(trim($estado))) {
                '1', 'true', 'on', 'yes', 'activo' => true,
                '0', 'false', 'off', 'no', 'inactivo' => false,
                default => null,
            };
        }

        return null;
    }
}
