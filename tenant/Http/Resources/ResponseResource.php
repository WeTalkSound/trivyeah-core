<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
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
            "user_identifier" => $this->user_identifier,
            "processed" => $this->processed,
            "processor" => $this->processor,
            "hook_responses" => HookResponseResource::collection($this->hookResponses),
            "answers" => AnswerResource::collection($this->answers)
        ];
    }
}
