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

$factory->define(Ohio\Storage\File\File::class, function (Faker\Generator $faker) {
    // skip if no internet connection
    // local disk into seed folder
    // pass values into file record...

    $disk = Storage::disk('local');

    $width = 640;
    $height = 480;

    $file = new \Illuminate\Http\File($faker->image(null, $width, $height));

    $disk->putFileAs('public/seeds', $file, $file->getFilename());

    return [
        'disk' => 'local',
        'name' => $file->getFilename(),
        'path' => sprintf('public/seeds/%s', $file->getFilename()),
        'http' => sprintf('/storage/seeds/%s', $file->getFilename()),
        'size' => $file->getSize(),
        'mimetype' => $file->getMimeType(),
        'width' => $width,
        'height' => $height,
        'title' => $faker->words(rand(3,7), true),
        'note' => $faker->paragraphs(rand(1,3), true),
    ];
});