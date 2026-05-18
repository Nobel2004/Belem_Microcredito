<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenhorRequest;
use App\Models\Emprestimos;
use App\Models\Penhores;
use App\Services\PenhorService;

class PenhoresController extends Controller
{
    public function __construct(
        protected PenhorService $service
    ) {}

    public function store(StorePenhorRequest $request, Emprestimos $emprestimo)
    {
        try {
            $this->service->registar($emprestimo, $request->validated(), auth()->id());
            return back()->with('success', 'Penhor registado');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function resgatar(Penhores $penhor)
    {
        try {
            $this->service->resgatar($penhor);
            return back()->with('success', 'Penhor resgatado');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function confiscar(Penhores $penhor)
    {
        try {
            $this->service->confiscar($penhor);
            return back()->with('success', 'Penhor confiscado');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}