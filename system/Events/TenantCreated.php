<?php

namespace System\Events;

use TrivYeah\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Tenancy\Identification\Contracts\Tenant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TenantCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tenant;

    public $tenantUserInformation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant, Fluent $tenantUserInformation)
    {
        $this->tenant = $tenant;
        $this->tenantUserInformation = $tenantUserInformation;
    }
}
