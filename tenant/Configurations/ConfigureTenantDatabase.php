<?php

namespace Tenant\Configurations;

use Tenancy\Facades\Tenancy;
use Tenancy\Concerns\DispatchesEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Identification\Events\Identified;
use Tenancy\Affects\Connections\Events\Resolved;
use Tenancy\Affects\Connections\Events\Resolving;

class ConfigureTenantDatabase
{
    use DispatchesEvents;
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Identified $event)
    {
        $connection = Tenancy::getTenantConnectionName();
        $provider = $this->events()->until(new Resolving($event->tenant, $connection));

        $this->events()->dispatch(new Resolved($event->tenant, $connection, $provider));

        if (! is_null(config("database.connections.$connection"))) {
            config(["database.default" => $connection]);
        }
    }
}
