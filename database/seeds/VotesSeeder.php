<?php

use Illuminate\Database\Seeder;
use App\Vote;

class VotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Vote::class, 50)->create();
    }
}
