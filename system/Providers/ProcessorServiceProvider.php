<?php

namespace System\Providers;

use TrivYeah\Support\Processor;
use Illuminate\Support\ServiceProvider;

class ProcessorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Processor::class, Processor::class);
    }
}
