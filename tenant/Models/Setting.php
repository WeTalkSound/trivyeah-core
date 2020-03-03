<?php

namespace Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
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