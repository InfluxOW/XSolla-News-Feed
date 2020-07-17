<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'created_at' => $faker->dateTimeBetween('-3 months')
    ];
});

$factory->afterMaking(Article::class, function ($article, $faker) {
    $user = \App\User::inRandomOrder()->take(1)->first();
    $category = \App\Category::inRandomOrder()->take(1)->first();

    $article->user()->associate($user);
    $article->category()->associate($category);
});
