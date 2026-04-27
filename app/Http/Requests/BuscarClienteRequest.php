<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BuscarClienteRequest extends FormRequest
{
    /**
     * La autorizacion se resuelve desde la policy del controller.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza los datos antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'tipo_busqueda' => $this->input('tipo_busqueda', 'dni'),
            'valor' => trim((string) $this->input('valor', '')),
        ]);
    }

    /**
     * Reglas de validacion para la busqueda de clientes.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'tipo_busqueda' => ['required', 'in:dni,apellido'],
            'valor' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Aplica validacion especifica segun el tipo de busqueda.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($this->input('tipo_busqueda') === 'dni' && ! ctype_digit($this->input('valor'))) {
                $validator->errors()->add('valor', 'Para buscar por DNI debe ingresar solo numeros.');
            }
        });
    }
}
