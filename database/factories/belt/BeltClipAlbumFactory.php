<?php

$factory->define(Belt\Clip\Album::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->words(random_int(1, 2), true),
        'body' => $faker->paragraphs(3, true),
    ];
});