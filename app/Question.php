<?php

namespace App;

use App\Notifications\UpdateQuestion;
use App\RecordActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use RecordActivity, Searchable;

	protected $guarded = [];
    protected $with = ['creator', 'topics:id,topic'];
    protected $appends = ['isSubscribed'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($question) {
            $question->answers->each->delete();
        });
        
    }


    public function path()
    {
    	return "/questions/" . $this->slug;
    }

    public function answers()
    {
    	return $this->hasMany('App\Answer')->withoutGlobalScopes();
    }

    public function creator()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function AnswerQuestion($answer)
    {
        $answer = $this->answers()->create($answer);
        $this->update(['updated_at' => Carbon::now()]);
        $this->notifySubscribers($answer);
        return $answer;
    }

    public function notifySubscribers($answer)
    {
        foreach($this->subscriptions as $subscription) {
            if($answer->user_id != $subscription->user_id) {
                $subscription->user->notify(new UpdateQuestion($this, $answer));
            }
        }
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?:auth()->id()
        ]);
        return $this;
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function unsubscribe($userId = null)
    {
        return $this->subscriptions()
                    ->where('user_id', $userId ?:auth()->id())
                    ->delete();
    }

    public function getisSubscribedAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }

    public function hasUpdated($user = null)
    {
        $user = $user ?: auth()->user();
        $key = sprintf("user.%s.visits.%s", $user->id, $this->id);
        return $this->updated_at > cache($key);
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic', 'topic_question');
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }

    public function hasTopic($topic)
    {
        return $this->topics()->where('topic', $topic)->exists();
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function getCacheKey()
    {
        return sprintf("user.%s.visits.%s", auth()->id(), $this->id);
    }

}
