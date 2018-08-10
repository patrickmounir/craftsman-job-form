<?php

use Faker\Generator as Faker;

$factory->define(App\JobRequest::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'service_id' => function () {
            return factory(\App\Service::class)->create()->id;
        },

        'title' => $faker->word,
        'description' => $faker->sentence,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'deadline' => $faker->dateTimeBetween('+1 days', '+30 days')->format('Y-m-d'),
    ];
});
