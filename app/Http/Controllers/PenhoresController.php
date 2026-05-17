<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Emprestimos;
use App\Services\PenhorService;
use Illuminate\Http\Request;

class PenhorController extends Controller
{
    protected $service;

    public function __construct(
        PenhorService $service
    ) {
        $this->service = $service;
    }

    public function store(
        Request $request,
        Emprestimos $emprestimo
    ) {

        $this->service->criar(
            $emprestimo,
            $request->all()
        );

        return back();
    }
}