<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [

        'parcela_id',
        'valor_pago',
        'data_pagamento',
        'recebido_por'

    ];

    public function parcela()
    {
        return $this->belongsTo(Parcela::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(User::class, 'recebido_por');
    }
}