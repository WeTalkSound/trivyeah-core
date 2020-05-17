<?php

namespace Tenant\Models;

use TrivYeah\Traits\Savable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use Savable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'response_id', 'text', 'value'
    ];

    /**
     * Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Response
     */
    public function response()
    {
        return $this->belongsTo(Response::class);
    }
}