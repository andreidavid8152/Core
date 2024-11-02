<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario ha iniciado sesión
        if (!session()->has('usuario')) {
            return redirect()->route('login');
        }

        // Verificar si el usuario es administrador y bloquear acceso a rutas de usuario
        if (session('usuario')->email === 'admin@super.com') {
            return redirect()->route('admin.dashboard')->with('error', 'Acceso denegado.');
        }

        return $next($request);
    }
}
