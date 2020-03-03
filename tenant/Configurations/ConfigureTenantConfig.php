<?php

namespace Tenant\Configurations;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Affects\Connections\Events\Drivers\Configuring;

class ConfigureTenantConfig
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Configuring $event)
    {
        $defaultConfig = $event->configuration;

        $event->useConfig(
            tenant_path("database/config.php"), $defaultConfig
        );
    }
}
