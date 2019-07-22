<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\ExchangeRate;

class ExchangeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\ExchangeRate', function ($app) {
          return new ExchangeRate();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
