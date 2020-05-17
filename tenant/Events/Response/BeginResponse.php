<?php

namespace Tenant\Events\Response;

use TrivYeah\Support\Fluent;
use TrivYeah\Traits\Permissible;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeginResponse
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Permissible;

    public $dto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Fluent $dto)
    {
        $this->dto = $dto;
    }
}
