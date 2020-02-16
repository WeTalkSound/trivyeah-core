<?php

namespace Tenant\Configurations;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Hooks\Migration\Events\ConfigureMigrations;

class ConfigureTenantMigrations
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ConfigureMigrations $event)
    {
        $event->path(base_path('tenant/database/migrations'));
    }
}
