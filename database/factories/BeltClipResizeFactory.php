<?php

use Belt\Core\Helpers\FactoryHelper;
use Illuminate\Http\UploadedFile;
use Belt\Clip\Adapters\AdapterFactory;

$factory->define(Belt\Clip\Resize::class, function (Faker\Generator $faker, $params = null) {

    $file = array_get($params, 'file');

    return [
        'file_id' => $file->id,
        'driver' => $file->driver,
        'path' => $file->path,
        'name' => $file->name,
        'mimetype' => $file->mimetype,
        'size' => $file->size,
        'original_name' => $file->original_name,
        'mode' => $faker->randomElement(['fit', 'resize']),
        'width' => $faker->randomElement([100, 200, 300, 400, 500]),
        'height' => $faker->randomElement([100, 200, 300, 400, 500]),
    ];

});