<?php

namespace Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id',
    ];

    /**
     * Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}