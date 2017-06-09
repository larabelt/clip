<?php

namespace Belt\Clip\Services\Cloudinary;

use Belt, Cloudinary, Storage;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use League\Flysystem\Filesystem;

/**
 * Class CloudinaryServiceProvider
 * @package Belt\Clip
 */
class CloudinaryServiceProvider extends BaseServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('cloudinary', function ($app, $config) {

            Cloudinary::config([
                "cloud_name" => array_get($config, 'cloud_name'),
                "api_key" => array_get($config, 'api_key'),
                "api_secret" => array_get($config, 'api_secret'),
            ]);

            return new Filesystem(new CloudinaryFlysystemAdapter($config));
        });
    }

}