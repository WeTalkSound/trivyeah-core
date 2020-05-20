<?php

namespace Tenant\Events\Response;

use Tenant\Models\Form;
use TrivYeah\Support\Fluent;
use TrivYeah\Traits\Permissible;
use Illuminate\Support\Collection;
use Illuminate\Broadcasting\Channel;
use TrivYeah\Abstracts\HookableEvent;
use Illuminate\Queue\SerializesModels;
use Tenant\Http\Resources\FormResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeginResponse implements HookableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Permissible;

    public $dto;

    protected $form;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Fluent $dto)
    {
        $this->dto = $dto;
    }

    public static function name(): string
    {
        return "begin_response";
    }

    public function load(): array
    {
        $form = $this->form();
        
        $formResource = new FormResource($form);

        $load['form'] = $formResource->toArray(request());
        $load['user_identifier'] = $this->dto->user_identifier;

        return $load;
    }

    public function form(): Form
    {
        return $this->form ?: $this->form = Form::findOrFail($this->dto->form_id);
    }

    public function hooks(): Collection
    {
        return $this->form()->hooks()
            ->where('event', static::name())->get();
    }
}
