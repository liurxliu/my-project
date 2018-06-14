<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    protected $with = ['subject'];

    public function subject()
    {
    	return $this->morphTo();
    }

    public static function feed(User $user)
    {
    	return static::where('user_id', $user->id)->latest()->get()->groupBy(function ($activity) {
    		  return $activity->created_at->format('Y-m-d');
    	});
    }
}
