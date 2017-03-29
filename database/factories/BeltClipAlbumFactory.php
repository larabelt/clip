<?php

use Belt\Core\Helpers\FactoryHelper;

$factory->define(Belt\Clip\Album::class, function (Faker\Generator $faker) {

    if (!isset(FactoryHelper::$ids['teams'])) {
        FactoryHelper::$ids['teams'] = Belt\Core\Team::get(['id'])->pluck('id')->toArray();
    }

    if (!isset(FactoryHelper::$ids['users'])) {
        FactoryHelper::$ids['users'] = Belt\Core\User::get(['id'])->pluck('id')->toArray();
    }

    return [
        'user_id' => $faker->randomElement(FactoryHelper::$ids['users']),
        'team_id' => $faker->randomElement(FactoryHelper::$ids['teams']),
        'name' => $faker->words(random_int(1, 2), true),
        'intro' => $faker->paragraphs(1, true),
        'body' => $faker->paragraphs(3, true),
    ];
});