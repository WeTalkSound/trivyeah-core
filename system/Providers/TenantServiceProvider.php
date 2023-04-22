<?php

namespace System\Providers;

use Tenancy\Environment;
use System\Mixin\TenancyMixin;
use System\Models\Organization;
use Illuminate\Contracts\Http\Kernel;
use TrivYeah\Providers\TenantProvider;
use TrivYeah\Support\SettingsResolver;
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
        $this->resolveTenancy();

        include_once(base_path("tenant/helpers.php"));

        Environment::mixin(new TenancyMixin);

        $this->registerTenantSettings();
    }

    // public function register()
    // {
    //     $this->resolveTenancy();
    // }

    public function resolveTenancy()
    {
        $this->app->resolving(ResolvesTenants::class, function (ResolvesTenants $resolver) {
            $resolver->addModel(Organization::class);

            return $resolver;
        });

        $this->app->register(TenantProvider::class);
    }

    /**
     * Register Tenant Settings
     */
    public function registerTenantSettings()
    {
        $this->app->make(SettingsResolver::class)->resolve();
    }
}
