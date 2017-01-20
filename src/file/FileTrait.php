<?php
namespace Ohio\Storage\File;

use Ohio\Storage\File\Adapters\BaseAdapter;
use Ohio\Storage\File\Adapters\AdapterFactory;

trait FileTrait
{
    /**
     * @var BaseAdapter
     */
    protected $adapter;

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

}