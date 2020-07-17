<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /** @test */
    public function a_user_can_fetch_all_categories()
    {
        factory(Category::class, 3)->create();

        $response = $this->getJson(route('categories.index'))
            ->assertOk();
        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function a_user_can_fetch_all_news_in_one_category()
    {
        $category = factory(Category::class)->create();
        $news = factory(Article::class, 3)->create(['category_id' => $category, 'user_id' => factory(User::class)->create()]);

        $response = $this->getJson(route('categories.show', $category))
            ->assertOk();
        $this->assertCount(3, $response->json('data'));
    }
}
