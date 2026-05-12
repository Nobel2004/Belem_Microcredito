<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class FuncionarioMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar autenticação
        if (!Auth::check()) {
            abort(401, 'Não autenticado');
        }

        $user = Auth::user();

        // Verificar se tem role
        if (!$user || !$user->role) {
            abort(403, 'Acesso negado');
        }

        // <permitir admin e funcionario
        if (!in_array($user->role->name, ['admin', 'funcionario'])) {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}