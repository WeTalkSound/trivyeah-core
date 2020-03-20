<?php

namespace Tenant\Models;

use TrivYeah\Traits\HasMeta;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model implements Sortable
{
    use SortableTrait, HasMeta;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_id', 'type', 'options', 'value', 'order', 'text'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        "meta" => "array"
    ];

    /**
     * Section
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function meta()
    {
        return [
            "options" => null,
            "value" => null
        ];
    }
}