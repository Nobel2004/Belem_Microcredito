<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação para criação de cliente.
     */
    public function rules(): array
    {
        return [
            'nome'         => ['required', 'string', 'max:255'],
            'bi'           => ['required', 'string', 'max:20', 'unique:clientes,bi'],
            'telefone'     => ['required', 'string', 'max:20'],
            'endereco'     => ['required', 'string', 'max:500'],
            'renda_mensal' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'nome.required'         => 'O nome é obrigatório.',
            'nome.max'              => 'O nome não pode ter mais de 255 caracteres.',
            'bi.required'           => 'O BI é obrigatório.',
            'bi.unique'             => 'Este BI já está registado.',
            'bi.max'                => 'O BI não pode ter mais de 20 caracteres.',
            'telefone.required'     => 'O telefone é obrigatório.',
            'endereco.required'     => 'O endereço é obrigatório.',
            'renda_mensal.required' => 'A renda mensal é obrigatória.',
            'renda_mensal.numeric'  => 'A renda mensal deve ser um valor numérico.',
            'renda_mensal.min'      => 'A renda mensal não pode ser negativa.',
        ];
    }
}