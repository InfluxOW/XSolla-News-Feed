<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(Vote::class, function ($vote, $faker) {
    $user = \App\User::inRandomOrder()->take(1)->first();
    $article = \App\Article::inRandomOrder()->take(1)->first();

    if (Vote::where('user_id', $user->id)->where('article_id', $article->id)->exists()) {
        return;
    }

    $vote->user()->associate($user);
    $vote->article()->associate($article);
});
