<?php

return [
    'drivers' => [
        'default' => [
            'disk' => 'public',
            'adapter' => \Belt\Storage\Adapters\LocalAdapter::class,
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
            \Belt\Content\Page::class,
            \Belt\Spot\Place::class,
        ],
    ],
];