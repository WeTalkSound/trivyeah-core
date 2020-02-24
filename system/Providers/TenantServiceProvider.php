<?php

namespace System\Providers;

use Tenancy\Environment;
use System\Mixin\TenancyMixin;
use System\Models\Organization;
use Illuminate\Support\ServiceProvider;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Affects\Connections\Events\Resolved;
use Tenancy\Affects\Connections\Events\Resolving;
use Tenancy\Identification\Contracts\ResolvesTenants;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include_once(base_path("tenant/helpers.php"));

        Environment::mixin(new TenancyMixin);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving(ResolvesTenants::class, function (ResolvesTenants $resolver) {
            $resolver->addModel(Organization::class);
            
            return $resolver;
        });
    }
}