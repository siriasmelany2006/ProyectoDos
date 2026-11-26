<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    // Uso en rutas: ->middleware('rol:admin') o ->middleware('rol:tienda')
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Inicia sesión para continuar.');
        }

        if (Auth::user()->rol !== $rol) {
            abort(403, 'No tienes permiso para entrar a esta sección.');
        }

        return $next($request);
    }
}