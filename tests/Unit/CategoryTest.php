<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected  $category;

    protected function setUp():void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
    }

    /** @test */
    public function it_has_news()
    {
        $acticle = factory(Article::class)->create(['category_id' => $this->category, 'user_id' => factory(User::class)->create()]);

        $this->assertInstanceOf(Collection::class, $this->category->news);
        $this->assertCount(1, $this->category->news);
        $this->assertTrue($this->category->news->contains($acticle));
    }
}
