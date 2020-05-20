<?php

namespace Tenant\Models;

use TrivYeah\Traits\Savable;
use Illuminate\Database\Eloquent\Model;

class Hook extends Model
{
    use Savable;
    
    protected $fillable = [
        'id','form_id', 'name', 'event', 'callback'
    ];
}
