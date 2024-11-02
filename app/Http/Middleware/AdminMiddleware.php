<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usuario')) {
            return redirect()->route('login');
        }

        if (session('usuario')->email !== 'admin@super.com') {
            return redirect()->route('home')->with('error', 'Acceso denegado.');
        }

        return $next($request);
    }
}
