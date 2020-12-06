<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\Auth\AuthServiceInterface',
            'App\Services\Auth\AuthService'
        );

        $this->app->bind(
            'App\Services\JWT\JwtServiceInterface',
            'App\Services\JWT\JwtService'
        );
    }
}
