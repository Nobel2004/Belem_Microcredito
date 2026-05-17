<?php

namespace App\Services;

use App\Models\Emprestimo;
use App\Models\Emprestimos;
use App\Models\Penhor;
use App\Models\Penhores;

class PenhorService
{
    public function criar(
        Emprestimos $emprestimo,
        array $data
    ) {

        /**
         * REGRA:
         * bem deve valer 150%
         */
        $minimo = $emprestimo->valor * 1.5;

        if ($data['valor_bem'] < $minimo) {
            throw new \Exception(
                'Bem inferior a 150%'
            );
        }

        return Penhores::create([

            'emprestimo_id' => $emprestimo->id,
            'descricao' => $data['descricao'],
            'valor_bem' => $data['valor_bem']

        ]);
    }
}