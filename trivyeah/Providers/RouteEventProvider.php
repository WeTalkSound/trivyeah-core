<?php

namespace TrivYeah\Providers;

use Illuminate\Support\Fluent;
use TrivYeah\Support\RouteName;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use TrivYeah\Middlewares\ResolveEvents;
use TrivYeah\Support\RouteEventRegister;

class RouteEventProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RouteEventRegister::class, function ($app) {
            return new RouteEventRegister;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(RouteEventRegister::class)->resolve();
    }
}