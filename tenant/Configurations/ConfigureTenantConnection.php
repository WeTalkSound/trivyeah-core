<?php

namespace Tenant\Configurations;

use Tenancy\Concerns\DispatchesEvents;
use Illuminate\Queue\InteractsWithQueue;
use Tenant\Listeners\ConnectionListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Affects\Connections\Events\Resolving;
use Tenancy\Affects\Connections\Events\Drivers\Configuring;
use Tenancy\Affects\Connections\Contracts\ProvidesConfiguration;

class ConfigureTenantConnection implements ProvidesConfiguration
{
    use DispatchesEvents;

    public function handle(Resolving $event)
    {
        return $this;
    }

    public function configure(Tenant $tenant): array
    {
        $config = [];

        $this->events()->dispatch(new Configuring($tenant, $config, $this));

        return $config;
    }
}
