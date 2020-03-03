<?php

namespace System\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HostnameResource extends JsonResource
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
            "fqdn" => $this->fqdn,
            "protocol" => $this->protocol
        ];
    }
}
