<?php

namespace Tenant\Listeners;

use Tenancy\Facades\Tenancy;
use System\Events\TenantCreated;
use Tenant\Services\TenantService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetUpTenantUser
{
    /**
     * @var TenantSerivce
     */
    protected $service;

    /**
     * Inject Service
     * @param TenantService
     */
    public function __construct(TenantService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TenantCreated $event)
    {
        Tenancy::runWithin($event->tenant, function () use ($event) {
            $userInformation = $event->tenantUserInformation;
            $userInformation["name"] = $userInformation["user_name"];
            $userInformation["email"] = $userInformation["user_email"];

            $this->service->createUser($userInformation);
        });
    }
}
