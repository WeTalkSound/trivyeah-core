<?php

namespace Tenant\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug'
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

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
