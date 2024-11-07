<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cambia el idioma basado en la sesión o un parámetro de la URL
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            session(['applocale' => $locale]);
            App::setLocale($locale);
        } elseif (session()->has('applocale')) {
            App::setLocale(session('applocale'));
        }

        return $next($request);
    }
}
