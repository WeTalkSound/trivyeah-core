<?php

namespace Tenant\Events\Question;

use Tenant\Models\Question;
use TrivYeah\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuestionUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question;

    public $dto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Question $question, Fluent $dto)
    {
        $this->question = $question;
        $this->dto = $dto;
    }
}
