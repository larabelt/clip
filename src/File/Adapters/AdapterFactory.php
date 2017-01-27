<?php
namespace Ohio\Storage\File\Adapters;

class AdapterFactory
{

    public static $adapters = [];

    /**
     * @param $driver
     * @return BaseAdapter
     * @throws \Exception
     */
    public static function up($driver = 'default')
    {
        if (isset(static::$adapters[$driver])) {
            return static::$adapters[$driver];
        }

        $adapterClass = config("ohio.storage.drivers.$driver.adapter");

        if (!$adapterClass || !class_exists($adapterClass)) {
            throw new \Exception('adapter for file driver type not specified or available');
        }

        return static::$adapters[$driver] = new $adapterClass($driver);
    }

}