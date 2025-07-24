<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            if (Auth::check()) {
                $roles = DB::table('user_roles')
                    ->where('user_id', Auth::user()->id)
                    ->pluck('roles_id')
                    ->toArray();
            } else {
                $roles = [];
            }

            $view->with('roles', $roles);
        });
    }
}
