<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('role', function (string|array $roles) {
            return auth()->check() && auth()->user()->hasRole($roles);
        });

        Blade::if('permission', function (string $permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        Blade::if('superadmin', function () {
            return auth()->check() && auth()->user()->isSuperAdmin();
        });
    }
}
