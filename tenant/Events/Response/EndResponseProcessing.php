<?php

namespace Tenant\Events\Response;

use Tenant\Models\Form;
use Tenant\Models\Response;
use TrivYeah\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Broadcasting\Channel;
use TrivYeah\Abstracts\HookableEvent;
use Illuminate\Queue\SerializesModels;
use Tenant\Http\Resources\FormResource;
use Illuminate\Broadcasting\PrivateChannel;
use Tenant\Http\Resources\ResponseResource;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EndResponseProcessing implements HookableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    public $processed;

    public $form;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public static function name(): string
    {
        return "end_response_processing";
    }

    public function load(): array
    {
        $form = $this->form();
        
        $formResource = new FormResource($form);
        $responseResource = new ResponseResource($this->response);

        $load['form'] = $formResource->toArray(request());
        $load['response'] = $responseResource->toArray(request());

        return $load;
    }

    public function form(): Form
    {
        return $this->form ?: $this->form = $this->response->form;
    }

    public function hooks(): Collection
    {
        return $this->form()->hooks()
            ->where('event', static::name())->get();
    }
}
