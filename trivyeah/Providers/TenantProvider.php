<?php

namespace TrivYeah\Providers;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class TenantProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteEventProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
 
    }
}