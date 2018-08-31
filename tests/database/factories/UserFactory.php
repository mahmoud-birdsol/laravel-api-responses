<?php

use Faker\Generator as Faker;

$factory->define(Alacrity\Responses\Tests\Models\User::class, function (Faker $faker) {
    return [
        'name'     => $faker->name,
        'email'    => $faker->email,
        'password' => bcrypt('password'),
    ];
});
