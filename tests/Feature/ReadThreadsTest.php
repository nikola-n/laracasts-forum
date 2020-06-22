<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase {
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $this->thread = create(Thread::class);

    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_single_thread()
    {
        $this->withoutExceptionHandling();
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associate_with_a_thread()
    {
        $this->withoutExceptionHandling();
        $reply = create(Reply::class,['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())->assertStatus(200);
    }

}
