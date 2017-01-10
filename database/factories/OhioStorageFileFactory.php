<?php

use Ohio\Core\Base\Helper\FactoryHelper;
use Illuminate\Http\File as FileInfo;

$factory->define(Ohio\Storage\File\File::class, function (Faker\Generator $faker) {

    $disk = Storage::disk('local');

    // build image array if empty
    if (!FactoryHelper::$images) {
        FactoryHelper::$images = $disk->allFiles('ohio/database/images');
        shuffle(FactoryHelper::$images);
    }

    // pop image from array
    $image = array_pop(FactoryHelper::$images);

    // get file info object
    $fileInfo = new FileInfo(storage_path("app/$image"));

    // copy file in new location
    $result = $disk->putFileAs('public/seeds', $fileInfo, sprintf('%s.%s', uniqid(), $fileInfo->guessExtension()));
    $filename = str_replace('public/seeds/', '', $result);

    $sizes = getimagesize($fileInfo->getRealPath());

    return [
        'disk' => 'local',
        'name' => $filename,
        'original_name' => $fileInfo->getFilename(),
        'path' => sprintf('public/seeds/%s', $filename),
        'http' => sprintf('/storage/seeds/%s', $filename),
        'size' => $fileInfo->getSize(),
        'mimetype' => $fileInfo->getMimeType(),
        'width' => $sizes[0],
        'height' => $sizes[1],
        'title' => $faker->words(rand(3,7), true),
        'note' => $faker->paragraphs(rand(1,3), true),
    ];
});