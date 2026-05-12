<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Inertia\Inertia;

class ClienteController extends Controller
{
    /**
     * Listar clientes
     */
    public function index()
    {
        $clientes = Cliente::query()
            ->latest()
            ->paginate(10);

        return Inertia::render('Clientes/Index', [
            'clientes' => $clientes
        ]);
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return Inertia::render('Clientes/Create');
    }

    /**
     * Salvar cliente
     */
    public function store(StoreClienteRequest $request)
    {
        Cliente::create([

            'nome' => $request->nome,
            'bi' => $request->bi,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'renda_mensal' => $request->renda_mensal,

            'created_by' => auth()->id()

        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso');
    }

    /**
     * Formulário de edição
     */
    public function edit(Cliente $cliente)
    {
        return Inertia::render('Clientes/Edit', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Atualizar cliente
     */
    public function update(
        UpdateClienteRequest $request,
        Cliente $cliente
    ) {

        $cliente->update([

            'nome' => $request->nome,
            'bi' => $request->bi,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'renda_mensal' => $request->renda_mensal,

        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado');
    }

    /**
     * Remover cliente
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()
            ->back()
            ->with('success', 'Cliente removido');
    }
}