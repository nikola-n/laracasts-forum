<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    //if there are situations where you don't want to include
    //creator you can't disable it
    //then you use globalscopes
    //Thread::withoutGlobalScopes()->first();
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        //updated migration no need for this
        //static::addGlobalScope('replyCount', function ($builder) {
        //    $builder->withCount('replies');
        //});

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
            //$thread->replies->each(function ($reply) {
            //    $reply->delete();
            //});
        });
        //static::addGlobalScope('creator', function ($builder) {
        //    $builder->with('creator');
        //});
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);

        //$reply->increment('replies_count');

        //return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
        return $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }
}
