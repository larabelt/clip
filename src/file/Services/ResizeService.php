<?php
namespace Ohio\Storage\File\Services;

use Ohio\Storage\File\File;
use Intervention\Image\ImageManager;

class ResizeService
{

    public $defaults = [
        'driver' => 'imagick',
    ];

    public $config = [];

    /**
     * @var ImageManager
     */
    public $manager;

    /**
     * @var array
     */
    public $presets = [];

    public function __construct($config = [])
    {
        $this->config = array_merge($this->defaults, $config);

        $this->presets();
    }

    public function config($key = null)
    {
        if ($key) {
            return array_get($this->config, $key);
        }

        return $this->config;
    }

    public function presets()
    {
        return $this->presets ?: $this->presets = config('ohio.storage.resizes.presets');
    }

    public function manager()
    {
        return $this->manager ?: $this->manager = new ImageManager(['driver' => $this->config('driver')]);
    }


    public function resize(File $file)
    {
        s($file->name);
        s($this->presets);

        $manipulator = $this->manager()->make($file->file_path);

        foreach ($this->presets as $preset) {
            s($preset);
        }


    }

}