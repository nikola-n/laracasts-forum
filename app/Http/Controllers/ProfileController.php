<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities'  => Activity::feed($user),
        ]);
    }

    /**
     * @param \App\User $user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getActivity(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activities) {
            return $activities->created_at->format('Y-m-d');
        });
    }

}
