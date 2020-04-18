<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Model;

class Hostname extends Model
{
    protected $fillable = [
        "fqdn", "protocol", "organization_id", "is_base"
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeBase($query)
    {
        return $query->where("is_base", true);
    }
}
