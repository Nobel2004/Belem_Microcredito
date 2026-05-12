<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [

        'nome',
        'bi',
        'telefone',
        'endereco',
        'renda_mensal',
        'created_by'

    ];

    public function criador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function emprestimos()
    {
        return $this->hasMany(Emprestimos::class);
    }
}