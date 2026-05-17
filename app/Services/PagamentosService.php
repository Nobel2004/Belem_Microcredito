<?php

namespace App\Services;

use App\Models\Emprestimo;
use App\Models\Emprestimos;
use App\Models\Pagamento;

class PagamentoService
{
    /**
     * Registar um pagamento para um empréstimo aprovado.
     *
     * Fluxo:
     *  1. Valida que o empréstimo está aprovado
     *  2. Regista o pagamento
     *  3. Verifica se o empréstimo está totalmente pago
     *     → se sim, marca como 'liquidado'
     */
    public function pagar(
        Emprestimos $emprestimo,
        array $data,
        int $userId
    ): Pagamento {

        // REGRA: só empréstimos aprovados recebem pagamentos
        if ($emprestimo->status !== 'aprovado') {
            throw new \Exception(
                'Apenas empréstimos aprovados podem receber pagamentos.'
            );
        }

        $valorPago = $data['valor_pago'];

        // Calcula o total já pago até ao momento
        $totalPagoAnteriormente = $emprestimo->pagamentos()->sum('valor_pago');

        // Calcula o valor total do empréstimo com juros
        $valorComJuros = $emprestimo->valor + ($emprestimo->valor * $emprestimo->juros / 100);

        // REGRA: não pode pagar mais do que o saldo restante
        $saldoRestante = $valorComJuros - $totalPagoAnteriormente;

        if ($valorPago > $saldoRestante) {
            throw new \Exception(
                "Valor pago ({$valorPago}) excede o saldo restante ({$saldoRestante})."
            );
        }

        // Regista o pagamento
        $pagamento = Pagamento::create([
            'emprestimo_id' => $emprestimo->id,
            'valor_pago'    => $valorPago,
            'created_by'    => $userId,
        ]);

        // Verifica liquidação total
        $totalPagoAgora = $totalPagoAnteriormente + $valorPago;

        if ($totalPagoAgora >= $valorComJuros) {
            $emprestimo->status = 'liquidado';
            $emprestimo->save();
        }

        return $pagamento;
    }
}