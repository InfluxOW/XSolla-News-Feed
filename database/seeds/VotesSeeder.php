<?php

use Illuminate\Database\Seeder;
use App\Vote;
use App\User;
use App\Article;

class VotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Article::all() as $article) {
            $usersCount = random_int(1, 3);
            $users = User::inRandomOrder()->take($usersCount)->get();

            $users->each(function ($user) use ($article) {
                if (Vote::where('user_id', $user->id)->where('article_id', $article->id)->doesntExist()) {
                    $vote = Vote::make();

                    $vote->user()->associate($user);
                    $vote->article()->associate($article);

                    $vote->save();
                }
            });
        }
    }
}
