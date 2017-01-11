<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Ohio\Storage\File\File;

class AdapterFactory
{

    public static $adapters = [];

    /**
     * @param null $disk
     * @return BaseAdapter
     * @throws \Exception
     */
    public static function up($disk = null)
    {
        $disk = $disk ?: config('filesystems.default');

        if (isset(static::$adapters[$disk])) {
            return static::$adapters[$disk];
        }

        $adapterClass = config("ohio.storage.disks.$disk.adapter");
        if (!$adapterClass || !class_exists($adapterClass)) {
            throw new \Exception('adapter for file disk type not specified or available');
        }

        return static::$adapters[$disk] = new $adapterClass($disk);
    }

}