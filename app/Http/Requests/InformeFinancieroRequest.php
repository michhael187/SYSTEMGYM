<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeFinancieroRequest extends FormRequest
{
    /**
     * La autorizacion se resuelve desde Gate en el controller.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para filtrar el informe financiero.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => ['nullable', 'date', 'after_or_equal:fecha_desde'],
        ];
    }
}