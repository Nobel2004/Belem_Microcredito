<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenhorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descricao'      => ['required', 'string', 'max:500'],
            'valor_avaliado' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required'      => 'A descrição do bem é obrigatória.',
            'valor_avaliado.required' => 'O valor avaliado é obrigatório.',
            'valor_avaliado.numeric'  => 'O valor avaliado deve ser numérico.',
            'valor_avaliado.min'      => 'O valor avaliado deve ser maior que zero.',
        ];
    }
}