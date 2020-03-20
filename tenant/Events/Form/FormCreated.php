<?php

namespace Tenant\Events\Form;

use Tenant\Models\Form;
use TrivYeah\Support\Fluent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FormCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $form;

    public $dto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Form $form, Fluent $dto)
    {
        $this->form = $form;
        $this->dto = $dto;
    }
}
