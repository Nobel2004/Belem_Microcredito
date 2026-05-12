<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimos extends Model
{
    protected $fillable = [

        'cliente_id',
        'valor',
        'taxa_juros',
        'prazo_meses',
        'valor_total',
        'status',
        'created_by'

    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function parcelas()
    {
        return $this->hasMany(Parcelas::class);
    }

    public function penhor()
    {
        return $this->hasOne(Penhores::class);
    }
}