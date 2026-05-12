<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(401, 'Não autenticado');
        }

        if (Auth::user()->role?->name !== 'admin') {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}