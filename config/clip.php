<?php

return [
    'default_driver' => 'local',
    'drivers' => [
        'local' => [
            'disk' => 'public',
            'adapter' => \Belt\Clip\Adapters\LocalAdapter::class,
            'prefix' => env('APP_ENV'),
            'src' => [
                'root' => sprintf('%s/storage', env('APP_URL')),
            ],
            'secure' => [
                'root' => sprintf('%s/storage', env('APP_URL'))
            ],
        ],
        'cloudinary' => [
            'disk' => 'cloudinary',
            'adapter' => \Belt\Clip\Adapters\CloudinaryAdapter::class,
            'prefix' => env('APP_ENV'),
            'src' => [
                'root' => env('CLOUDINARY_SRC'),
            ],
            'secure' => [
                'root' => env('CLOUDINARY_SECURE'),
            ],
        ]
    ],
    'resize' => [
        'local_driver' => 'local',
        'image_driver' => 'gd',
        'models' => [
            \Belt\Clip\Album::class => [
                [100, 100, 'fit'],
                [800, 800, 'fit'],
            ],
        ],
    ],
];