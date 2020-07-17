<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\User;
use App\Vote;
use Tests\TestCase;

class VoteTest extends TestCase
{
    protected $article;
    protected $user;
    protected $vote;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $this->vote = factory(Vote::class)->create(['user_id' => $this->user, 'article_id' => $this->article]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->vote->user);
    }

    /** @test */
    public function it_belongs_to_an_article()
    {
        $this->assertInstanceOf(Article::class, $this->vote->article);
    }
}
