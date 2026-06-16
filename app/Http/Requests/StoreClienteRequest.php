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
     * Normaliza el campo estado y los decimales antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'estado' => $this->normalizarEstado($this->input('estado')),
            'peso' => $this->normalizarDecimal($this->input('peso')),
            'altura' => $this->normalizarDecimal($this->input('altura')),
        ]);
    }

    /**
     * Reglas de validacion para registrar un nuevo cliente.
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'digits_between:7,8', 'unique:clientes,dni'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'digits_between:10,13'],
            'peso' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'altura' => ['nullable', 'numeric', 'min:0', 'max:300'],
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
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits_between' => 'El DNI debe tener entre 7 y 8 números.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits_between' => 'El teléfono debe tener al menos 10 numeros.',
            'peso.numeric' => 'El peso debe ser un número válido (usa punto o coma para decimales).',
            'peso.min' => 'El peso no puede ser un valor negativo.',
            'peso.max' => 'El peso no puede superar 500.',
            'altura.numeric' => 'La altura debe ser un número válido (usa punto o coma para decimales).',
            'altura.min' => 'La altura no puede ser un valor negativo.',
            'altura.max' => 'La altura no puede superar 300.',
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

    private function normalizarDecimal(mixed $valor): mixed
    {
        if (! is_string($valor)) {
            return $valor;
        }

        $valor = trim($valor);

        return $valor === '' ? null : str_replace(',', '.', $valor);
    }
}
