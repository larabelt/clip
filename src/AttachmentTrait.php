<?php

namespace Belt\Clip;

use Belt\Clip\Adapters\BaseAdapter;
use Belt\Clip\Adapters\AdapterFactory;

/**
 * Class AttachmentTrait
 * @package Belt\Clip
 */
trait AttachmentTrait
{

    /**
     * @var BaseAdapter
     */
    public $adapter;

    /**
     * @return BaseAdapter
     */
    public function adapter()
    {
        return $this->adapter ?: AdapterFactory::up($this->driver);
    }

    /**
     * @return mixed
     */
    public function getSrcAttribute()
    {
        return $this->adapter()->src($this);
    }

    /**
     * @return mixed
     */
    public function getSecureAttribute()
    {
        return $this->adapter()->secure($this);
    }

    /**
     * @return mixed
     */
    public function getContentsAttribute()
    {
        return $this->adapter()->contents($this);
    }

    /**
     * @return string
     */
    public function getRelPathAttribute()
    {
        if ($this->name && $this->path) {
            return sprintf('%s/%s', $this->path, $this->name);
        }

        return $this->name ?: null;
    }

    /**
     * Is file an image
     *
     * @return boolean
     */
    public function getIsImageAttribute()
    {
        return strpos($this->mimetype, 'image/') !== false;
    }

    /**
     * @param $value
     */
    public function setDriverAttribute($value)
    {
        $this->attributes['driver'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setPathAttribute($value)
    {
        $this->attributes['path'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setOriginalNameAttribute($value)
    {
        $this->attributes['original_name'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setMimetypeAttribute($value)
    {
        $this->attributes['mimetype'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = trim($value);
    }

    /**
     * @param $value
     */
    public function setWidthAttribute($value)
    {
        $this->attributes['width'] = (integer) trim($value);
    }

    /**
     * @param $value
     */
    public function setHeightAttribute($value)
    {
        $this->attributes['height'] = (integer) trim($value);
    }

    /**
     * @return string
     */
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

    /**
     * @param array $data
     * @return mixed
     */
    public static function setAttributesFromUpload(array $data = [])
    {
        $attributes = [
            'driver' => array_get($data, 'driver', null),
            'name' => array_get($data, 'name', null),
            'original_name' => array_get($data, 'original_name', null),
            'path' => array_get($data, 'path', null),
            'size' => array_get($data, 'size', null),
            'mimetype' => array_get($data, 'mimetype', null),
            'width' => array_get($data, 'width') ?: 0,
            'height' => array_get($data, 'height') ?: 0,
        ];

        return $attributes;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function createFromUpload(array $data = [])
    {
        static::unguard();

        $attributes = static::setAttributesFromUpload($data);

        return static::create($attributes);
    }

}