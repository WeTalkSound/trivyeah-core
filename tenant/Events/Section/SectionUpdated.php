<?php

namespace Tenant\Events\Section;

use Tenant\Models\Section;
use TrivYeah\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SectionUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $section;

    public $dto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Section $section, Fluent $dto)
    {
        $this->section = $section;
        $this->dto = $dto;
    }
}
