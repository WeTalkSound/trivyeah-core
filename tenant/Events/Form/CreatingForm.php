<?php

namespace Tenant\Events\Form;

use Tenant\Models\Form;
use Illuminate\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatingForm
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $formDto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Fluent $formDto)
    {
        $this->formDto = $formDto;
    }
}
