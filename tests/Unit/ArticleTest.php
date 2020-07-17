<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\User;
use App\Vote;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    protected $article;
    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->category = factory(Category::class)->create();
        $this->article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => $this->category]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->article->user);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $this->assertInstanceOf(Category::class, $this->article->category);
    }

    /** @test */
    public function it_has_votes()
    {
        $vote = factory(Vote::class)->create(['article_id' => $this->article, 'user_id' => $this->user]);

        $this->assertInstanceOf(Collection::class, $this->article->votes);
        $this->assertCount(1, $this->article->votes);
        $this->assertTrue($this->article->votes->contains($vote));
    }

    /** @test */
    public function it_slug_updates_according_to_the_title_update()
    {
        $slug = slugify("{$this->article->title}_" . $this->article->created_at->format('Y-m-d H:i'));
        $this->assertEquals($this->article->slug, $slug);

        $this->article->update(['title' => 'new title']);
        $updatedSlug = slugify("{$this->article->fresh()->title}_" . $this->article->created_at->format('Y-m-d H:i'));

        $this->assertEquals($this->article->slug, $updatedSlug);
    }
}
