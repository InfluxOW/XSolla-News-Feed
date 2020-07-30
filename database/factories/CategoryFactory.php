<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $title = $faker->words(3, true);

    return [
        'title' => $title,
        'slug' => slugify($title),
        'description' => $faker->words(15, true)
    ];
});
