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
        'title', 'slug', 'lang', 'parent_id', 'published_at'
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

    public function languages()
    {
        return $this->hasMany(static::class, "parent_id");
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
