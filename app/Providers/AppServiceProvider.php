<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gates por rol
        Gate::define('ver-admin', function (User $user){
            return $user->rol === 'admin';
        });

        Gate::define('ver-pastor', function (User $user){
            return $user->rol === 'pastor';
        });

        // Módulos generales
        Gate::define('ver-finanzas', function (User $user){
            return in_array($user->rol, ['admin', 'pastor', 'miembro']);
        });

        Gate::define('ver-configuracion', function (User $user){
            return in_array($user->rol, ['admin', 'pastor']);
        });

        Gate::define('ver-usuarios', function (User $user){
            return $user->rol === 'admin';
        });
    }
}
