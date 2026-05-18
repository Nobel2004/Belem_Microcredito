<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmprestimoRequest;
use App\Models\Cliente;
use App\Models\Emprestimos;
use App\Services\EmprestimoService;
use Inertia\Inertia;

class EmprestimoController extends Controller
{
    public function __construct(
        protected EmprestimoService $service
    ) {}

    public function index()
    {
        return Inertia::render('Emprestimos/Index', [
            'emprestimos' => Emprestimos::with('cliente')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Emprestimos/Create', [
            'clientes'   => Cliente::orderBy('nome')->get(['id', 'nome', 'renda_mensal']),
            'taxa_juros' => $this->service->getTaxaJuros(),
        ]);
    }

    public function store(StoreEmprestimoRequest $request)
    {
        try {
            $this->service->criar($request->validated(), auth()->id());

            return redirect()
                ->route('emprestimos.index')
                ->with('success', 'Empréstimo criado com sucesso');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Emprestimos $emprestimo)
    {
        return Inertia::render('Emprestimos/Show', [
            'emprestimo' => $emprestimo->load(['cliente', 'parcelas', 'pagamentos', 'penhores']),
        ]);
    }

    public function aprovar(Emprestimos $emprestimo)
    {
        try {
            $this->service->aprovar($emprestimo);
            return back()->with('success', 'Empréstimo aprovado');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function rejeitar(Emprestimos $emprestimo)
    {
        try {
            $this->service->rejeitar($emprestimo);
            return back()->with('success', 'Empréstimo rejeitado');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Emprestimos $emprestimo)
    {
        $emprestimo->deleteOrFail();
        return back()->with('success', 'Empréstimo removido');
    }
}