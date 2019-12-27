<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Sections
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Responses
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    /**
     * Themes
     */
    public function theme()
    {
        return $this->hasOne(Theme::class);
    }
}
