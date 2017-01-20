<?php
namespace Ohio\Storage\File;

use Ohio\Storage\File\Adapters\BaseAdapter;
use Ohio\Storage\File\Adapters\AdapterFactory;

trait FileTrait
{
    /**
     * @var BaseAdapter
     */
    public $adapter;

    public function adapter()
    {
        return $this->adapter ?: AdapterFactory::up($this->disk);
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

    public function setDiskAttribute($value)
    {
        $this->attributes['disk'] = trim($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setOriginalNameAttribute($value)
    {
        $this->attributes['original_name'] = trim($value);
    }

    public function setFilePathAttribute($value)
    {
        $this->attributes['file_path'] = trim($value);
    }

    public function setWebPathAttribute($value)
    {
        $this->attributes['web_path'] = trim($value);
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

    public static function createFromUpload(array $attributes = [])
    {
        static::unguard();

        $attributes2 = [
            'disk' => array_get($attributes, 'disk', null),
            'name' => array_get($attributes, 'name', null),
            'original_name' => array_get($attributes, 'original_name', null),
            'file_path' => array_get($attributes, 'file_path', null),
            'web_path' => array_get($attributes, 'web_path', null),
            'size' => array_get($attributes, 'size', null),
            'mimetype' => array_get($attributes, 'mimetype', null),
            'width' => array_get($attributes, 'width', null),
            'height' => array_get($attributes, 'height', null),
        ];

        return static::create($attributes2);
    }

}