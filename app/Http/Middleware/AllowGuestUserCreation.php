<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowGuestUserCreation
{
    public function handle(Request $request, Closure $next)
    {
        // Permitir acceso a la ruta de creación de usuarios
        if ($request->is('users/create') || $request->is('users')) {
            return $next($request);
        }

        return redirect('/login'); // Redirigir a login para otras rutas
    }
}
