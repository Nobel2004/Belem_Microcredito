<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Emprestimo;
use App\Models\Emprestimos;

class EmprestimoService
{
    /**
     * Taxa de juros única aplicada a todos os empréstimos (em %)
     */
    private const TAXA_JUROS = 10;

    /**
     * Regras de negócio para criação de empréstimo
     */
    public function criar(array $data, int $userId): Emprestimos
    {
        $cliente = Cliente::findOrFail($data['cliente_id']);

        // REGRA 1: limite baseado na renda mensal (30%)
        $limite = $cliente->renda_mensal * 0.3;

        if ($data['valor'] > $limite) {
            throw new \Exception(
                "Valor excede o limite permitido de {$limite} (30% da renda mensal)"
            );
        }

        // REGRA 2: taxa de juros única
        $juros = self::TAXA_JUROS;

        return Emprestimos::create([
            'cliente_id'  => $cliente->id,
            'valor'       => $data['valor'],
            'juros'       => $juros,
            'status'      => 'pendente',
            'created_by'  => $userId,
        ]);
    }

    /**
     * Retorna a taxa de juros aplicada
     */
    public function getTaxaJuros(): int
    {
        return self::TAXA_JUROS;
    }

    /**
     * Aprovar empréstimo
     */
    public function aprovar(Emprestimos $emprestimo): Emprestimos
    {
        if ($emprestimo->status !== 'pendente') {
            throw new \Exception(
                "Apenas empréstimos pendentes podem ser aprovados."
            );
        }

        $emprestimo->status = 'aprovado';
        $emprestimo->save();

        return $emprestimo;
    }

    /**
     * Rejeitar empréstimo
     */
    public function rejeitar(Emprestimos $emprestimo): Emprestimos
    {
        if ($emprestimo->status !== 'pendente') {
            throw new \Exception(
                "Apenas empréstimos pendentes podem ser rejeitados."
            );
        }

        $emprestimo->status = 'rejeitado';
        $emprestimo->save();

        return $emprestimo;
    }
}