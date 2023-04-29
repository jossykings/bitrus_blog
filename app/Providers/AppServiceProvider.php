<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::if('admin', function () {
            return auth()->user()->role == '1';
        });
        Blade::if('user', function () {
            return auth()->user()->role == '0';
        });
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
