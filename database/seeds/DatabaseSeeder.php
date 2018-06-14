<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Question', 30)->create()->each(function ($question) {
        	factory('App\Answer', 10)->create(['question_id' => $question->id]);
        });
    }
}
