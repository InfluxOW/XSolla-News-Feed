<?php

namespace App\Providers;

use App\Article;
use App\Category;
use App\Observers\CategoriesObserver;
use App\Observers\NewsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(NewsObserver::class);
        Category::observe(CategoriesObserver::class);
    }
}
