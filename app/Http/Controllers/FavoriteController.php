<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function __construct()
    {
            $this->middleware('auth');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Reply $reply)
    {
       return $reply->favorite();
    }

}
