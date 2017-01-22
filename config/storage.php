<?php

return [
    'drivers' => [
        'default' => [
            'disk' => 'public',
            'adapter' => \Ohio\Storage\File\Adapters\LocalAdapter::class,
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
        'disk' => 'public',
        'driver' => 'imagick',
        'presets' => [
            'thumb' => [100, 100]
        ],
    ],
];