<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penhores extends Model
{
    protected $fillable = [

        'emprestimo_id',
        'descricao',
        'valor_avaliado',
        'imagem',
        'status'

    ];

    public function emprestimo()
    {
        return $this->belongsTo(Emprestimos::class);
    }
}