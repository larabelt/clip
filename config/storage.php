<?php

return [
    'disks' => [
        'public' => [
            'adapter' => \Ohio\Storage\File\Adapters\LocalAdapter::class,
            'http' => env('APP_URL', 'http://localhost'),
            'https' => env('APP_URL', 'http://localhost'),
            'file_prefix' => '',
            'web_prefix' => 'storage',
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