<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        //set locale to english/US
        setlocale(LC_ALL, 'en_US.UTF-8');

        if (! defined('TIMEZONE')) {
            define('TIMEZONE', 'America/New_York');
        }

        if (! defined('MONEY_FORMAT')) {
            define('MONEY_FORMAT', '%.2n');
        }

        Schema::defaultStringLength(191);
    }
}
