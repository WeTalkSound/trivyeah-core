<?php

namespace Tenant\Configurations;

use TenantSeeder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Hooks\Migration\Events\ConfigureSeeds;

class ConfigureTenantSeeders
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ConfigureSeeds $event)
    {
        $event->seed(TenantSeeder::class);
    }
}
