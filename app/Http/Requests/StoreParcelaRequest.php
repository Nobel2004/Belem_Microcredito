<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParcelaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parcela_id' => ['required', 'integer', 'exists:parcelas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'parcela_id.required' => 'A parcela é obrigatória.',
            'parcela_id.exists'   => 'Parcela não encontrada.',
        ];
    }
}