<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultation;
use Faker\Generator as Faker;

$factory->define(Consultation::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'name' => $faker->name,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'role' => $faker->randomElement($array = array (1, 2))
    ];
});
