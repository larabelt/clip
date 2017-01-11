<?php

use Ohio\Core\Base\Helper\FactoryHelper;
use Illuminate\Http\UploadedFile;
use Ohio\Storage\File\Adapters\AdapterFactory;

$factory->define(Ohio\Storage\File\File::class, function (Faker\Generator $faker) {

    $adapter = AdapterFactory::up('public');

    // build image array if empty
    FactoryHelper::$images = FactoryHelper::$images ?: $adapter->disk->allFiles('ohio/database/images');
    $image = FactoryHelper::popImage();

    // get file info object
    $fileInfo = new UploadedFile(storage_path("app/public/$image"), $image);

    // copy file in new location
    $result = $adapter->upload('uploads', $fileInfo);

    return array_merge($result, [
        'title' => $faker->words(rand(3, 7), true),
        'note' => $faker->paragraphs(rand(1, 3), true),
    ]);

});