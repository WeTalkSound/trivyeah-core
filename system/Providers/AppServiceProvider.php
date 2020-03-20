<?php

namespace System\Providers;

use Illuminate\Support\Fluent;
use System\Mixin\RequestMixin;
use System\Mixin\CollectionMixin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
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
        include_once(app_path("helpers.php"));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Request::mixin(new RequestMixin);
        Collection::mixin(new CollectionMixin);
 
    }
}
