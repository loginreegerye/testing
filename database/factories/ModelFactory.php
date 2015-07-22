<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => Hash::make('userpassword'),
        'role' => 'user',
        'remember_token' => null,
    ];
});

$factory->define(App\Book::class, function ($faker) {
	$genres = ['comedy', 'drama', 'epic', 'nonsense', 'lyric', 'romance', 'satire', 'tragedy'];
	$users_count = 25; // factory('App\User', 25)->create(); | users count from table `users`
	
	return [
		'user_id' => rand(0, ($users_count-3)),
		'title' => $faker->sentence(3),
		'author' => $faker->lastName,
		'year' => rand(1980, 2015),
		'genre' => $genres[rand(0, (count($genres)-1))],
	];
});