<?php

namespace Tenant\Listeners;

use Tenancy\Facades\Tenancy;
use System\Events\TenantCreated;
use Tenant\Services\FormService;
use Tenant\Services\TenantService;
use Tenant\Events\Form\FormUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleHooksOnFormUpdated
{
    /**
     * @var FormSerivce
     */
    protected $service;

    /**
     * Inject Service
     * @param FormService
     */
    public function __construct(FormService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FormUpdated $event)
    {
        $hooks = $event->dto->getOrCollect("hooks");

        $this->service->handleHooks($hooks, $event->form);
    }
}
