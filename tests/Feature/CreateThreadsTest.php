<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_a_thread()
    {
        $this->withExceptionHandling();

        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_new_forum_thread()
    {
        $this->withoutExceptionHandling();
        //given we have a signed in user
        $this->signIn();
        //when we hit the endpoint to create a new thread
        //then we visit the thread page
        $thread = create(Thread::class);

        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())
            //we should see the new thread-
            ->assertSee($thread->title)
            ->assertSee($thread->body)
            ->assertSee($thread->channel_id);
    }
}
