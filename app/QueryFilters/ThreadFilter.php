<?php

namespace App\QueryFilters;

use App\User;

class ThreadFilter extends QueryFilters
{

    protected $filters = ['by', 'popular', 'unanswered'];

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

    /**
     * Filter the query according to the most popular threads
     *
     * @return mixed
     */
    protected function popular()
    {
        //this overrides all orders made
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * @return mixed
     */
    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
