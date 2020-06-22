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
        $this->post('threads/some-channel/1/replies', [])
        ->assertRedirect('/login');
    }

    /** @test */
    public function an_auth_user_may_participate_in_forum_threads()
    {
        //we have auth user
        $this->signIn();
        //and an existing thread
        $thread = create(Thread::class);
        //when the user adds a reply to the thread
        $reply= make(Reply::class);

        $this->post($thread->path() .'/replies', $reply->toArray());
        //then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body'=> null]);

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
