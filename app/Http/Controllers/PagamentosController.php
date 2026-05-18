<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagamentoRequest;
use App\Models\Emprestimos;
use App\Services\PagamentoService;

class PagamentoController extends Controller
{
    public function __construct(
        protected PagamentoService $service
    ) {}

    public function store(StorePagamentoRequest $request, Emprestimos $emprestimo)
    {
        try {
            $this->service->pagar(
                $emprestimo,
                $request->validated(),
                auth()->id()  // @phpstan-ignore-line (falso positivo Intelephense)
            );

            return back()->with('success', 'Pagamento registado com sucesso');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}