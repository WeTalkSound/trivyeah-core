<?php

namespace Tenant\Listeners;

use Tenant\Models\Form;
use Tenant\Models\Response;
use Illuminate\Queue\InteractsWithQueue;
use Tenant\Events\Response\BeginResponse;
use Illuminate\Contracts\Queue\ShouldQueue;

class BeginResponseHook
{
    /**
     * @var Tenant\Models\Response
     */
    protected $response;

    /**
     * Inject Response
     * @param Tenant\Models\Response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BeginResponse $event)
    {
        $form = Form::findOrFail($event->dto->form_id);
    }
}
