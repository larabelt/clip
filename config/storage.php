<?php

return [
    'drivers' => [
        'default' => [
            'disk' => 'public',
            'adapter' => \Ohio\Storage\Adapters\LocalAdapter::class,
            'prefix' => env('APP_ENV'),
            'src' => [
                'root' => sprintf('%s/storage', env('APP_URL')),
            ],
            'secure' => [
                'root' => sprintf('%s/storage', env('APP_URL'))
            ],
        ]
    ],
    'resize' => [
        'local_driver' => 'default',
        'image_driver' => 'imagick',
        'models' => [
            \Ohio\Content\Page::class,
            \Ohio\Spot\Place::class,
        ],
    ],
];