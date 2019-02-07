<?php

use Faker\Generator as Faker;

$factory->define(\App\Tweet::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    return [
        'body' => $faker->name,
        'title' => $faker->text,
        'user_id' => $faker->randomElement($users)
    ];
});
