<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagamentoRequest;
use App\Models\Emprestimo;
use App\Models\Emprestimos;
use App\Services\PagamentoService;

class PagamentoController extends Controller
{
    protected PagamentoService $service;

    public function __construct(PagamentoService $service)
    {
        $this->service = $service;
    }

    /**
     * Registar pagamento de um empréstimo.
     */
    public function store(
        StorePagamentoRequest $request,
        Emprestimos $emprestimo
    ) {
        try {

            /** @var \App\Models\User $user */
            $user = auth()->user();

            $this->service->pagar(
                $emprestimo,
                $request->validated(),
                $user->id
            );

            return back()->with('success', 'Pagamento registado com sucesso');

        } catch (\Exception $e) {

            return back()->withErrors(['error' => $e->getMessage()]);

        }
    }
}