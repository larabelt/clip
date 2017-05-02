<?php

return [
    'drivers' => [
        'default' => [
            'disk' => 'public',
            'adapter' => \Belt\Clip\Adapters\LocalAdapter::class,
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
            \Belt\Clip\Album::class => [
                [100, 100, 'fit'],
                [800, 800, 'fit'],
//                [222, 222, 'resize'],
//                [333, 333, 'resize'],
//                [500, 500, 'resize'],
            ],
        ],
    ],
];