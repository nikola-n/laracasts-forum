<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    public static function boot()
    {
        parent::boot();

        //    you can add it in addReply or here, the benefit here is when you
        //use model factory create it will automatically increment by 1
        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected $guarded = [];

    //it eager loads the owner anytime you fetch a reply
    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
