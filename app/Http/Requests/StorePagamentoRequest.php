<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'valor_pago' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'valor_pago.required' => 'O valor pago é obrigatório.',
            'valor_pago.numeric'  => 'O valor pago deve ser numérico.',
            'valor_pago.min'      => 'O valor pago deve ser maior que zero.',
        ];
    }
}