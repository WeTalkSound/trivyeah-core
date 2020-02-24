<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Hostname extends Model
{
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
