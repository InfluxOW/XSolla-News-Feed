<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authorized_user_can_create_news()
    {
        $user = factory(User::class)->create();
        $attributes = ['title' => 'title', 'content' => 'content'];

        $this->actingAs($user, 'api')
            ->postJson(route('news.store'), $attributes);
        $this->assertDatabaseHas('news', $attributes);
    }
}
