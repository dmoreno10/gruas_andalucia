<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
{
    // Verifica si hay un idioma guardado en la sesión
    if (Session::has('applocale')) {
        $locale = Session::get('applocale');
        App::setLocale($locale); // Establece el idioma actual
    } else {
        App::setLocale(config('app.locale')); // Establece el idioma predeterminado
    }

    return $next($request); // Continúa con la siguiente solicitud
}


}
