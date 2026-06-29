<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
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

        // Audit Trail for Login
        Event::listen(Login::class, function ($event) {
            $user = $event->user;
            AuditLog::create([
                'user_id' => $user->id,
                'activity' => 'login',
                'description' => "Pengguna '{$user->name}' berhasil masuk (login) ke sistem.",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        // Audit Trail for Logout
        Event::listen(Logout::class, function ($event) {
            $user = $event->user;
            if ($user) {
                AuditLog::create([
                    'user_id' => $user->id,
                    'activity' => 'logout',
                    'description' => "Pengguna '{$user->name}' keluar (logout) dari sistem.",
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });
    }
}
