<?php

namespace App;

trait RecordActivity
{
	public static function bootRecordActivity()
	{
        if (auth()->guest()) return;
        foreach (static::getRecordEvent() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
	}

    protected static function getRecordEvent()
    {
        return ['created'];
    }

	public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityEventType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function getActivityEventType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

}