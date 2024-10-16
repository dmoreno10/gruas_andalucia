<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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
            // Busca la configuración (puedes cambiar esto según sea necesario)
            $configuration = Configuration::find(1);

            // Comparte la variable con todas las vistas
            $view->with('configuration', $configuration);
        });
        Schema::defaultStringLength(191);
    }
}
