<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "event" => $this->event,
            "callback" => $this->callback
        ];
    }
}
