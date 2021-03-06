<?php

namespace App\Http\Controllers;

use App\Channel;
use App\QueryFilters\ThreadFilter;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Channel                   $channel
     *
     * @param \App\QueryFilters\ThreadFilter $filters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel, ThreadFilter $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'title'      => 'required',
                'body'       => 'required',
                'channel_id' => 'required|exists:channels,id',
            ]
        );

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id') ?: 1,
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        return redirect($thread->path())->with('flash', 'Your thread has been published.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Channel $channel
     * @param Thread       $thread
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show', [
            'thread'  => $thread,
            'replies' => $thread->replies()->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Channel $channel
     * @param \App\Thread  $thread
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete(Channel $channel, Thread $thread)
    {

        $this->authorize('update', $thread);
        //if ($thread->user_id != auth()->id()) {
        //    abort(403, 'You do not have permission to do this.');
        //}
        //if you don't add foreign key in db
        //$thread->replies()->delete();
        $thread->replies->each->delete();
        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads');
    }

    /**
     * @param \App\Channel                   $channel
     * @param \App\QueryFilters\ThreadFilter $filters
     *
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilter $filters)
    {
        $threads = Thread::filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        $threads = $threads->latest()->get();

        return $threads;
    }
}
