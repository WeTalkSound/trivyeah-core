<?php

namespace System\Providers;

use TrivYeah\Support\HookHandler;
use TrivYeah\Facades\HookHandler as HookHandlerFacade;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HookHandler::class, HookHandler::class);
    }

    public function boot()
    {
        $hookListener = HookHandlerFacade::listener();

        foreach (HookHandlerFacade::all() as $hookEvent) {
            
            $event = HookHandlerFacade::find($hookEvent);
            $this->app->events->listen($event, $hookListener);
        }
    }
}
