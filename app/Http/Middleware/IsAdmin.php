<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y si es un admin
        if (Auth::check() && Auth::user()->admin) {
            return $next($request);
        }

        // Si no es admin, redirigir a otra página (por ejemplo, la página principal)
        return redirect("/inicio")->with(
            "error",
            "No tienes permisos para acceder a esta página"
        );
    }
}
