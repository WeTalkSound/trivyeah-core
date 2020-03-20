<?php

namespace Tenant\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class Section extends Model implements Sortable
{
    use SortableTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'form_id', 'order'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}