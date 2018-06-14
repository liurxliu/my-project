<?php

namespace App;

use App\Likeable;
use App\Question;
use App\RecordActivity;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use RecordActivity, Likeable;
	protected $guarded = [];
    protected $appends = ['isLiked'];
    protected $with = ['owner:id,name,avatar_path', 'likes:id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleting(function($answer) {
            $answer->question->decrement('answers_count');
        });

        static::addGlobalScope('question', function($builder) {
            $builder->with('question:id,question,slug');
        });
    }

    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function path()
    {
        return $this->question->path() . '#answer-' . $this->id;
    }

}
