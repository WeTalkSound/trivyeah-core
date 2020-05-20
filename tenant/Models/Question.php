<?php

namespace Tenant\Models;

use TrivYeah\Traits\HasMeta;
use TrivYeah\Traits\Savable;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model implements Sortable
{
    use SortableTrait, HasMeta, Savable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_id', 'type', 'order', 'text'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        "meta" => "array",
    ];

    /**
     * Section
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function meta()
    {
        return [
            "options" => [],
            "value" => null
        ];
    }

    public function buildSortQuery()
    {
        return static::query()->where('section_id', $this->section_id);
    }
}