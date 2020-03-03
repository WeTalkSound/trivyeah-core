<?php

namespace Tenant\Configurations;

use Tenancy\Facades\Tenancy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Identification\Events\Identified;

class ConfigureTenantDatabase
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Identified $event)
    {
        Tenancy::setTenantConnection($event->tenant);
    }
}
