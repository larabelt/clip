<?php

return [
    'disks' => [
        'public' => [
            'adapter' => \Ohio\Storage\File\Adapters\LocalAdapter::class,
            'web_prefix' => 'storage'
        ]
    ],
];