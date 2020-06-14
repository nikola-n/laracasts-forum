<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_a_thread()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $thread = factory(Thread::class)->make();

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_create_a_new_forum_thread()
    {
        //given we have a signed in user
        $this->signIn(factory(User::class)->create());
        //when we hit the endpoint to create a new thread
        //then we visit the thread page
        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());
        $response = $this->get($thread->path())
        //we should see the new thread-
        ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
