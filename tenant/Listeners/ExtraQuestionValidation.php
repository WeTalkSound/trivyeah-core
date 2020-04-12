<?php

namespace Tenant\Listeners;

use Illuminate\Support\Str;
use System\Events\TenantCreated;
use Tenant\Services\FormService;
use Tenant\Services\TenantService;
use Tenant\Events\Form\SectionCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tenant\Events\Question\CreatingQuestion;
use Tenant\ResourceValidators\QuestionValidator;

class ExtraQuestionValidation
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
    public function handle(CreatingQuestion $event)
    {
        QuestionValidator::make($event->questionDto)->validateAndFail();
    }
}
