<?php

namespace Tests\Feature;

use App\Reply;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Thread;

class ParticipateInFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();
        $this->post('threads/1/replies', []);
    }

    /** @test */
    public function an_auth_user_may_participate_in_forum_threads()
    {
        //we have auth user
        $this->be(factory(User::class)->create());
        //and an existing thread
        $thread = factory(Thread::class)->create();
        //when the user adds a reply to the thread
        $reply= factory(Reply::class)->make();
        $this->post($thread->path() .'/replies', $reply->toArray());
        //then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
