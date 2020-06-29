<?php

namespace App\QueryFilters;

use App\User;

class ThreadFilter extends QueryFilters
{

    protected $filters = ['by'];
    /**
     * Filter the query by a given username
     *
     * @param string $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
