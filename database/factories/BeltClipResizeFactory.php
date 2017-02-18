<?php

$factory->define(Belt\Clip\Resize::class, function (Faker\Generator $faker, $params = null) {

    $attachment = array_get($params, 'attachment');

    return [
        'attachment_id' => $attachment->id,
        'driver' => $attachment->driver,
        'path' => $attachment->path,
        'name' => $attachment->name,
        'mimetype' => $attachment->mimetype,
        'size' => $attachment->size,
        'original_name' => $attachment->original_name,
        'mode' => $faker->randomElement(['fit', 'resize']),
        'width' => $faker->randomElement([100, 200, 300, 400, 500]),
        'height' => $faker->randomElement([100, 200, 300, 400, 500]),
    ];

});