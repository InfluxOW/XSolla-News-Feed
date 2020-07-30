<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vote;
use App\User;
use App\Article;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(Vote::class, function ($vote, $faker) {
    $user = User::inRandomOrder()->take(1)->first();
    $article = Article::inRandomOrder()->take(1)->first();

    $vote->user()->associate($user);
    $vote->article()->associate($article);
});
