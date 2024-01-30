<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RajaongkirServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path() . '/Helpers/RajaOngkir.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
