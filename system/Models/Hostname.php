<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Model;

class Hostname extends Model
{
    protected $fillable = [
        "fqdn", "protocol", "organization_id"
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
