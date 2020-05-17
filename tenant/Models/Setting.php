<?php

namespace Tenant\Models;

use TrivYeah\Traits\Savable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Savable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    /**
     * Predefined tenant settings
     * 
     * @return array
     */
    public static function defined()
    {
        return [
            'only_authenticated_users_can_create_forms' => false
        ];
    }
}