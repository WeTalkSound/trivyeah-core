<?php

namespace Tenant\Listeners;

use Tenancy\Facades\Tenancy;
use System\Events\TenantCreated;
use Tenant\Services\FormService;
use Tenant\Services\TenantService;
use Illuminate\Queue\InteractsWithQueue;
use Tenant\Events\Section\SectionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleQuestionOnSectionUpdated
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
    public function handle(SectionUpdated $event)
    {
        $questions = $event->dto->getOrCollect("questions");

        $this->service->handleQuestions($questions, $event->section);
    }
}
