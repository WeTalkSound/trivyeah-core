<?php

namespace Tenant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            "question" => new QuestionResource($this->question),
            "answer_text" => $this->text,
            "answer_value" => $this->value
        ];
    }
}
