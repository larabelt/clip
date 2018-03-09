<?php

return [
    'default_driver' => env('DEFAULT_CLIP_DRIVER', 'local'),
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
        ],
        's3' => [
            'disk' => 's3',
            'adapter' => \Belt\Clip\Adapters\S3LambdaAdapter::class,
            'prefix' => env('APP_ENV'),
            'src' => [
                'root' => sprintf('http://%s.s3-website-%s.amazonaws.com', env('AWS_BUCKET'), env('AWS_REGION')),
            ],
            'secure' => [
                'root' => sprintf('https://%s.s3-website-%s.amazonaws.com', env('AWS_BUCKET'), env('AWS_REGION')),
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