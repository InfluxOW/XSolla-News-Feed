<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\Http\Resources\NewsResource;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    protected $user;

    protected function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_unauthorized_user_can_not_manage_news()
    {
        $this->postJson(route('news.store'))
            ->assertUnauthorized();

        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $notArticleOwner = factory(User::class)->create();

        $this->be($notArticleOwner, 'api');
        $this->patchJson(route('news.update', $article))
            ->assertForbidden();
        $this->deleteJson(route('news.update', $article))
            ->assertForbidden();

    }

    /** @test */
    public function a_user_can_fetch_all_news()
    {
        factory(Article::class, 3)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);

        $response = $this->getJson(route('news.index'))
            ->assertOk();
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function a_user_can_fetch_all_news_ordered_by_popularity()
    {
        $news = factory(Article::class, 3)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);

        $fetchedNews = $this->getJson(route('news.index'))->json('data');
        $this->assertEquals($news->sortByDesc('created_at')->pluck('created_at')->toArray(), array_column($fetchedNews, 'created_at'));

        $anotherUser = factory(User::class)->create();
        $this->user->upvote($news[2]);
        $this->user->upvote($news[1]);
        $anotherUser->upvote($news[1]);

        $fetchedNewsByRating = $this->getJson(route('news.index', ['sortByRating' => 1]))->json('data');
        $this->assertEquals($news->fresh()->sortByDesc('votes_count')->pluck('votes_count')->toArray(), array_column($fetchedNewsByRating, 'rating'));
    }

    /** @test */
    public function a_user_can_view_an_article()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);

        $this->getJson(route('news.show', $article))
            ->assertOk()
            ->assertJsonStructure(['data' => ['title', 'content']]);
    }

    /** @test */
    public function an_authorized_user_can_create_news()
    {
        $attributes = ['title' => 'title', 'content' => 'content', 'category_id' => factory(Category::class)->create()->id];

        $this->actingAs($this->user, 'api')
            ->postJson(route('news.store'), $attributes)
            ->assertCreated();
        $this->assertDatabaseHas('news', $attributes);
    }

    /** @test */
    public function an_authorized_user_can_update_it()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $attributes = ['title' => 'title', 'content' => 'content'];

        $this->actingAs($this->user, 'api')
            ->patchJson(route('news.update', $article), $attributes)
            ->assertOk();
        $this->assertDatabaseHas('news', $attributes);
    }

    /** @test */
    public function an_authorized_user_can_delete_it()
    {
        $article = factory(Article::class)->create(['user_id' => $this->user, 'category_id' => factory(Category::class)->create()]);
        $this->actingAs($this->user, 'api')
            ->deleteJson(route('news.update', $article))
            ->assertNoContent();
        $this->assertDatabaseMissing('news', ['id' => $article->id]);
    }
}
