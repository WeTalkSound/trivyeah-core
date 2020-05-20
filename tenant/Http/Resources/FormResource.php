<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
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
            "title" => $this->title,
            "slug" => $this->slug,
            'max_response' => $this->max_response,
            'processor' => $this->processor,
            "sections" => SectionResource::collection($this->sections),
            "hooks" => HookResource::collection($this->hooks)
        ];
    }
}
