<?php

return [
    'disks' => [
        'public' => [
            'adapter' => \Ohio\Storage\File\Adapters\LocalAdapter::class,
            'web_prefix' => 'storage'
        ]
    ],
    'resizes' => [
        'presets' => [
            'thumb' => [100, 100]
        ],
    ],
];