<?php

namespace App;

use App\Activity;
use App\Thread;

trait RecordsActivity
{
    //this will be the same like you have created
    //a boot method on the model itself.
    protected static function bootRecordsActivity()
    {
        //when a new record was created in a database
        //here we save activity
        if(auth()->guest()) return;
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
        //listen for when any record is deleting this thread is associated with
        static::deleting(function ($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * @param $event
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event): string
    {
        //this will return the class name itself ex. App\Foo\Thread, it will return Thread
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'    => $this->getActivityType($event),

            //If you use it like this you don't need to hard code this two.
            //'subject_id'   => $this->id,
            //'subject_type' => get_class($this),
        ]);
    }

    //polymorphic methods
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
