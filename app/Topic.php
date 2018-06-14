<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'topic';
    }

    public function questions()
    {
    	return $this->belongsToMany('App\Question', 'topic_question');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User', 'topic_user');
    }
}
