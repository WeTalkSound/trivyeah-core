<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HookResponseResource extends JsonResource
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
            "hook" => new HookResource($this->hook),
            "status" => $this->status,
            "response" => $this->response,
        ];
    }
}
