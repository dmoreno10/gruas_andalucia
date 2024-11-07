<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Obtiene la configuración global (suponiendo que la configuración con ID 1 es la global)
            $configuration = Configuration::find(1);

            // Verifica si el usuario está autenticado
            $user = Auth::check() ? Auth::user() : null;

            // Si el usuario está autenticado, asignamos la imagen de perfil; si no, $userImage es null
            $userImage = $user ? ($user->profile_image ? asset('storage/' . $user->profile_image) : null) : null;

            // Compartimos las variables con todas las vistas
            $view->with([
                'configuration' => $configuration,
                'user' => $user,
                'userImage' => $userImage,
            ]);
        });

        Schema::defaultStringLength(191);
    }
}
