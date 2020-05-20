<?php

namespace Tenant\Models;

use TrivYeah\Traits\Savable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use TrivYeah\Abstracts\Processor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasSlug, Savable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'form_id', 'user_identifier', 'processed', 'processor'
    ];

    /**
     * Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Answers
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('user_identifier')
            ->saveSlugsTo('slug');
    }

    public function getAllByIdentifier($identifier)
    {
        return $this->where('user_identifier', $identifier)->get();
    }

    public function saveProcessed($processed, Processor $processor)
    {
        $this->processed = $processed;
        $this->processor = $processor->name();
        
        return $this->saveOnly();
    }

    public function hookResponses()
    {
        return $this->hasMany(HookResponse::class);
    }
}