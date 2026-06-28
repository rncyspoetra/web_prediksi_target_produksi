<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

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
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manajemen', function ($user) {
            return $user->role === 'manajemen';
        });

        Gate::define('admin-manajemen', function ($user) {
            return in_array($user->role, ['admin', 'manajemen']);
        });

        Paginator::useBootstrap();
    }
}
