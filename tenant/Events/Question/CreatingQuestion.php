<?php

namespace Tenant\Events\Question;

use TrivYeah\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatingQuestion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $questionDto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Fluent $questionDto)
    {
        $this->questionDto = $questionDto;
    }
}
