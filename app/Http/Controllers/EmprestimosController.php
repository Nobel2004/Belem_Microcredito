<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmprestimoRequest;
use App\Models\Cliente;
use App\Models\Emprestimo;
use App\Models\Emprestimos;
use App\Services\EmprestimoService;
use Inertia\Inertia;

class EmprestimoController extends Controller
{
    protected EmprestimoService $service;

    public function __construct(EmprestimoService $service)
    {
        $this->service = $service;
    }

    /**
     * Listar todos os empréstimos com o cliente associado.
     */
    public function index()
    {
        return Inertia::render('Emprestimos/Index', [
            'emprestimos' => Emprestimos::with('cliente')
                ->latest()
                ->paginate(10),
        ]);
    }

    /**
     * Formulário de criação — passa clientes e taxa de juros ao frontend.
     */
    public function create()
    {
        return Inertia::render('Emprestimos/Create', [
            'clientes'   => Cliente::all(),
            'taxa_juros' => $this->service->getTaxaJuros(),
        ]);
    }

    /**
     * Criar empréstimo — delega regras de negócio ao Service.
     */
    public function store(StoreEmprestimoRequest $request)
    {
        try {

            $this->service->criar(
                $request->validated(),
                auth()->id()
            );

            return redirect()
                ->route('emprestimos.index')
                ->with('success', 'Empréstimo criado com sucesso');

        } catch (\Exception $e) {

            return back()->withErrors(['error' => $e->getMessage()]);

        }
    }

    /**
     * Aprovar empréstimo.
     */
    public function aprovar(Emprestimos $emprestimo)
    {
        try {

            $this->service->aprovar($emprestimo);

            return back()->with('success', 'Empréstimo aprovado');

        } catch (\Exception $e) {

            return back()->withErrors(['error' => $e->getMessage()]);

        }
    }

    /**
     * Rejeitar empréstimo.
     */
    public function rejeitar(Emprestimos $emprestimo)
    {
        try {

            $this->service->rejeitar($emprestimo);

            return back()->with('success', 'Empréstimo rejeitado');

        } catch (\Exception $e) {

            return back()->withErrors(['error' => $e->getMessage()]);

        }
    }

    /**
     * Remover empréstimo.
     */
    public function destroy(Emprestimos $emprestimo)
    {
        $emprestimo->deleteOrFail();

        return back()->with('success', 'Empréstimo removido');
    }
}