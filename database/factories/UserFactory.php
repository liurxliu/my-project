<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Question::class, function (Faker $faker) {
    $question = $faker->sentence();
    $slug = str_slug($question);
    return [
    	'user_id' => function() {
    		return factory(App\User::class)->create()->id;
    	},
        'question' => $question,
        'slug' => $slug,
        'visits' => 0
    ];
});

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
    	'question_id' => function() {
    		return factory(App\Question::class)->create()->id;
    	},
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'answer' => $faker->paragraph(5),
    ];
});

$factory->define(App\Topic::class, function (Faker $faker) {
    return [
        'topic' => $faker->word
    ];
});

$factory->define(App\Like::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'likeable_id' => function() {
            return factory('App\Answer')->create()->id;
        },
        'likeable_type' => 'App\Answer',
    ];
});
