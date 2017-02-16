<?php
namespace Belt\Clip;

use Belt\Clip\Adapters\BaseAdapter;
use Belt\Clip\Adapters\AdapterFactory;

trait FileTrait
{

    /**
     * @var BaseAdapter
     */
    public $adapter;

    public function adapter()
    {
        return $this->adapter ?: AdapterFactory::up($this->driver);
    }

    public function getSrcAttribute()
    {
        return $this->adapter()->src($this);
    }

    public function getSecureAttribute()
    {
        return $this->adapter()->secure($this);
    }

    public function getContentsAttribute()
    {
        return $this->adapter()->contents($this);
    }

    public function getRelPathAttribute()
    {
        return sprintf('%s/%s', $this->path, $this->name);
    }

    public function setDriverAttribute($value)
    {
        $this->attributes['driver'] = trim($value);
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = trim($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setOriginalNameAttribute($value)
    {
        $this->attributes['original_name'] = trim($value);
    }

    public function setMimetypeAttribute($value)
    {
        $this->attributes['mimetype'] = trim($value);
    }

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = trim($value);
    }

    public function setWidthAttribute($value)
    {
        $this->attributes['width'] = trim($value);
    }

    public function setHeightAttribute($value)
    {
        $this->attributes['height'] = trim($value);
    }

    public function getReadableSizeAttribute()
    {
        $size = $this->size;

        if ($size >= 1 << 30) {
            return number_format($size / (1 << 30), 1) . " GB";
        }

        if ($size >= 1 << 20) {
            return number_format($size / (1 << 20), 1) . " MB";
        }

        if ($size >= 1 << 10) {
            return number_format($size / (1 << 10)) . " KB";
        }

        return number_format($size) . " bytes";
    }

    public static function createFromUpload(array $attributes = [])
    {
        static::unguard();

        $attributes2 = [
            'driver' => array_get($attributes, 'driver', null),
            'name' => array_get($attributes, 'name', null),
            'original_name' => array_get($attributes, 'original_name', null),
            'path' => array_get($attributes, 'path', null),
            'size' => array_get($attributes, 'size', null),
            'mimetype' => array_get($attributes, 'mimetype', null),
            'width' => array_get($attributes, 'width', null),
            'height' => array_get($attributes, 'height', null),
        ];

        return static::create($attributes2);
    }

}