<?php

namespace Tenant\Events\Form;

use Tenant\Models\Form;
use TrivYeah\Traits\Actable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FormUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $form;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
}
