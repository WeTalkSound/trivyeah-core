<?php

namespace Tenant\Events\Response;

use Tenant\Models\Response;
use TrivYeah\Support\Fluent;
use TrivYeah\Traits\Permissible;
use Illuminate\Support\Collection;
use Illuminate\Broadcasting\Channel;
use TrivYeah\Abstracts\HookableEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeginResponseProcessing implements HookableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Permissible;

    public $answers;

    public $response;

    public $form;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $answers, Response $response)
    {
        $this->answers = $answers;
        $this->response = $response;
    }

    public static function name(): string
    {
        return "begin_response_processing";
    }

    public function load(): array
    {
        $form = $this->form();
        
        $formResource = new FormResource($form);

        $load['form'] = $formResource->toArray();
        $load['answers'] = $this->answers->toArray();

        return $load;
    }

    public function form()
    {
        return $this->form ?: $this->form = $this->response->form;
    }

    public function hooks(): Collection
    {
        return $this->form()->hooks()
            ->where('event', static::name())->get();
    }
}
