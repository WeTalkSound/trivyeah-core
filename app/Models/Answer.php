<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'response_id', 'detail'
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