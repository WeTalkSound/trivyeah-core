<?php

namespace Tenant\Configurations;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Database\Drivers\Mysql\Driver\Mysql;
use Tenancy\Hooks\Database\Events\Drivers\Configuring;

class ConfigureTenantConnection
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Configuring $event)
    {
        
    }
}
