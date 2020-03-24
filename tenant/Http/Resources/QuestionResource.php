<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            "order" => $this->order,
            "type" => $this->type,
            "text" => $this->text,
            "options" => $this->options,
            "value" => $this->value
        ];
    }
}
