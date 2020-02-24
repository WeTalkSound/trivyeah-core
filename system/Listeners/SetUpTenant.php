<?php

namespace System\Listeners;

use System\Events\TenantCreated;
use Tenancy\Tenant\Events\Created;
use Tenancy\Concerns\DispatchesEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetUpTenant
{
    use DispatchesEvents;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TenantCreated $event)
    {
        $this->events()->dispatch(new Created($event->tenant));
    }
}
