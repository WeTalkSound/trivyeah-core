<?php

namespace Tenant\Configurations;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Hooks\Database\Events\Drivers\Creating;

class ConfigureTenantHost
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Creating $event)
    {
        $event->configuration["host"] = "%";
        
        $event->configuration["username"] = $event->tenant->getTenantKey();
    }
}
