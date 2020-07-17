<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VotesTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
    }

    /** @test */
    public function an_authorized_user_can_upvote_an_article_once()
    {
        $this->assertFalse($this->user->hasVotedFor($this->article));

        $this->actingAs($this->user, 'api')
            ->postJson(route('votes.store', $this->article))
            ->assertOk()
            ->assertJsonStructure(['article']);

        $this->assertTrue($this->user->hasVotedFor($this->article));

        $this->actingAs($this->user, 'api')
            ->postJson(route('votes.store', $this->article))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertTrue($this->user->hasVotedFor($this->article));
    }

    /** @test */
    public function an_authorized_user_can_downvote_an_article_once()
    {
        $this->user->upvote($this->article);
        $this->assertTrue($this->user->hasVotedFor($this->article));

        $this->actingAs($this->user, 'api')
            ->deleteJson(route('votes.destroy', $this->article))
            ->assertOk()
            ->assertJsonStructure(['article']);

        $this->assertFalse($this->user->hasVotedFor($this->article));

        $this->actingAs($this->user, 'api')
            ->deleteJson(route('votes.destroy', $this->article))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertFalse($this->user->hasVotedFor($this->article));
    }
}
