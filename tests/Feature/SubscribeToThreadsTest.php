<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

//when you hit an endpoint -move to bigger level
class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Some reply here',
        ]);

        //$this->assertCount(1,auth()->user()->notifications);

        $this->assertCount(1, $thread->subscriptions);
    }
}
