<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Services\ParcelaService;

class ParcelaController extends Controller
{
    public function __construct(
        protected ParcelaService $service
    ) {}

    /**
     * Pagar uma parcela específica.
     */
    public function pagar(Parcela $parcela)
    {
        try {
            $this->service->pagar($parcela);
            return back()->with('success', 'Parcela paga com sucesso');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}