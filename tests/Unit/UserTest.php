<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\User;
use App\Vote;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_has_news()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);

        $this->assertInstanceOf(Collection::class, $this->user->news);
        $this->assertCount(1, $this->user->news);
        $this->assertTrue($this->user->news->contains($article));
    }

    /** @test */
    public function it_has_votes()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $vote = factory(Vote::class)->create(['user_id' => $this->user, 'article_id' => $article]);

        $this->assertInstanceOf(Collection::class, $this->user->votes);
        $this->assertCount(1, $this->user->votes);
        $this->assertTrue($this->user->votes->contains($vote));
    }

    /** @test */
    public function it_can_upvote_an_article()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);

        $this->assertFalse($this->user->hasVotedFor($article));
        $this->user->upvote($article);
        $this->assertTrue($this->user->hasVotedFor($article->fresh()));
    }

    /** @test */
    public function it_can_downvote_an_article()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $vote = factory(Vote::class)->create(['user_id' => $this->user, 'article_id' => $article]);
        $this->assertTrue($this->user->hasVotedFor($article));

        $this->user->downvote($article);
        $this->assertFalse($this->user->hasVotedFor($article->fresh()));
    }
}
