<?php

namespace Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class HookResponse extends Model
{
    protected $fillable = [
        'hook_id', 'response_id', 'status', 'response'
    ];

    public function hook()
    {
        return $this->belongsTo(Hook::class);
    }

    public function response()
    {
        return $this->belongsTo(Response::class);
    }
}
