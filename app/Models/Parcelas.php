<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [

        'emprestimo_id',
        'numero',
        'valor',
        'vencimento',
        'status'

    ];

    public function emprestimo()
    {
        return $this->belongsTo(Emprestimos::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}