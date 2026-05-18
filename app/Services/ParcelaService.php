<?php

namespace App\Services;

use App\Models\Emprestimos;
use App\Models\Parcela;
use Carbon\Carbon;

class ParcelaService
{
    /**
     * Taxa de juros por atraso (% ao dia).
     */
    private const JUROS_ATRASO_DIARIO = 0.1; // 0.1% por dia

    /**
     * Gerar parcelas para um empréstimo aprovado.
     *
     * Passo 1 — calcula valor total (principal + juros do empréstimo)
     * Passo 2 — divide pelo número de meses
     * Passo 3 — cria uma parcela por mês com data de vencimento
     *
     * @param int $meses número de prestações (padrão: 12)
     */
    public function gerar(Emprestimos $emprestimo, int $meses = 12): void
    {
        // Evita gerar duplicadas
        if ($emprestimo->parcelas()->exists()) {
            return;
        }

        $valorTotal     = $emprestimo->valor_total;
        $valorParcela   = round($valorTotal / $meses, 2);
        $dataBase       = Carbon::now()->addMonth();

        for ($i = 1; $i <= $meses; $i++) {
            Parcela::create([
                'emprestimo_id'   => $emprestimo->id,
                'numero'          => $i,
                'valor'           => $valorParcela,
                'juros_atraso'    => 0,
                'valor_final'     => $valorParcela,
                'data_vencimento' => $dataBase->copy()->addMonths($i - 1),
                'status'          => 'pendente',
            ]);
        }
    }

    /**
     * Pagar uma parcela.
     * Se estiver atrasada, aplica juros de atraso sobre o valor.
     */
    public function pagar(Parcela $parcela): Parcela
    {
        if ($parcela->status === 'paga') {
            throw new \Exception('Parcela já está paga.');
        }

        $hoje         = Carbon::today();
        $jurosAtraso  = 0;
        $valorFinal   = $parcela->valor;

        // Calcula atraso em dias e aplica juros
        if ($parcela->isAtrasada()) {
            $diasAtraso  = $parcela->data_vencimento->diffInDays($hoje);
            $jurosAtraso = self::JUROS_ATRASO_DIARIO * $diasAtraso;
            $valorFinal  = $parcela->valor * (1 + $jurosAtraso / 100);
        }

        $parcela->update([
            'juros_atraso'   => $jurosAtraso,
            'valor_final'    => round($valorFinal, 2),
            'data_pagamento' => $hoje,
            'status'         => 'paga',
        ]);

        return $parcela;
    }

    /**
     * Actualiza estado das parcelas vencidas (chamar via scheduled job).
     */
    public function actualizarAtrasadas(): void
    {
        Parcela::where('status', 'pendente')
            ->where('data_vencimento', '<', Carbon::today())
            ->update(['status' => 'atrasada']);
    }
}