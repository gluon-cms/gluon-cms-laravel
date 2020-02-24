<?php

namespace App\Providers;

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
        $this->app->bind('gluon',function() {
            return new \App\Gluon\Sql\GluonSql;
        });

        $this->app->bind('gluonConfig',function() {
            return new \App\Gluon\Config\GluonConfig;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
