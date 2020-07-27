<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Channel             $channel
     * @param Thread                   $thread
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Channel $channel, Thread $thread, Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);
        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Reply has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reply               $reply
     *
     * @return void
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => $request->body]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted!']);
        }
        return back();
    }
}
