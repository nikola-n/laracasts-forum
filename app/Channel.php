<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
    //laravel 6.x
    //public function getRouteKeyName()
    //    //{
    //    //    return 'slug';
    //    //}
}

