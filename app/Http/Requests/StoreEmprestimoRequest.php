<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmprestimoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'integer', 'exists:clientes,id'],
            'valor'      => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists'   => 'Cliente não encontrado.',
            'valor.required'      => 'O valor é obrigatório.',
            'valor.numeric'       => 'O valor deve ser numérico.',
            'valor.min'           => 'O valor mínimo é 1.',
        ];
    }
}