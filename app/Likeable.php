<?php

namespace App;

trait Likeable 
{
    protected static function bootLikeable()
    {
        static::deleting(function($model) {
            $model->likes()->delete();
        });
    }
	public function likes()
    {
    	return $this->morphMany('App\Like', 'likeable');
    }

    public function like()
    {
    	if (!$this->likes()->where('user_id', auth()->id())->exists()) {
    		$this->likes()->create([
	    		'user_id' => auth()->id()
	    	]);
            $this->increment('likes_count');
    	}
    }

    public function unlike()
    {
        $this->likes()->where('user_id', auth()->id())->get()->each->delete();
        $this->decrement('likes_count');
    }

    public function isLiked()
    {
        return !! $this->likes->where('user_id', auth()->id())->count();
    }

    public function getisLikedAttribute()
    {
        return $this->isLiked();
    }
}