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
            'App\Services\Permission\PermissionServiceInterface',
            'App\Services\Permission\PermissionService'
        );

        $this->app->bind(
            'App\Services\Role\RoleServiceInterface',
            'App\Services\Role\RoleService'
        );
    }
}
