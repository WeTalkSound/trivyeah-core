<?php

namespace Tenant\Configurations;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenancy\Affects\Routes\Events\ConfigureRoutes;

class ConfigureTenantRoutes
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ConfigureRoutes $event)
    {
        $event->flush();

        $this->addWebRoutes($event);

        $this->addApiRoutes($event);
        
    }

    /**
     * addWebRoutes
     *
     * @param ConfigureRoutes $event
     *
     * @return void
     */
    protected function addWebRoutes(ConfigureRoutes $event)
    {
        $event->fromFile(
            ['middleware' => ['web']],
            base_path('/tenant/routes/web.php')
        );
    }

    /**
     * addApiRoutes
     *
     * @param  ConfigureRoutes $event
     *
     * @return void
     */
    protected function addApiRoutes(ConfigureRoutes $event)
    {
        $event->fromFile(
            ['middleware' => ['api'], 'prefix' => 'api'],
            base_path('/tenant/routes/api.php')
        );
    }
}
