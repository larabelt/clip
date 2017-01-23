<?php
namespace Ohio\Storage\File\Services;

use Ohio\Storage\File\Adapters;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Resize;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ResizeService
{

    /**
     * @var array
     */
    public $config = [];

    /**
     * @var array
     */
    public $presets = [];

    /**
     * @var Adapters\BaseAdapter
     */
    public $adapter;

    /**
     * @var ImageManager
     */
    public $manager;

    /**
     * @var Resize
     */
    public $resizeRepo;

    public function __construct($config = [])
    {
        $this->config = array_merge(config('ohio.storage.resize'), $config);
    }

    public function config($key = null, $default = false)
    {
        if ($key) {
            return array_get($this->config, $key, $default);
        }

        return $this->config;
    }

    public function presets()
    {
        return $this->presets ?: $this->presets = $this->config('presets', []);
    }

    public function adapter()
    {
        return $this->adapter ?: $this->adapter = Adapters\AdapterFactory::up($this->config('local_driver'));
    }

    public function manager()
    {
        return $this->manager ?: $this->manager = new ImageManager([
            'driver' => $this->config('image_driver'),
        ]);
    }

    public function resizeRepo()
    {
        return $this->resizeRepo ?: $this->resizeRepo = new Resize();
    }

    public function resize(File $file, $presets = [])
    {
        $adapter = $this->adapter ?: $file->adapter();

        $presets = $presets ?: $this->presets();

        $original = $this->manager()->make($file->contents);

        foreach ($presets as $preset => $params) {

            $w = $params[0];
            $h = $params[1];
            $mode = array_get($params, 2, 'fit');

            if ($file->__sized($w, $h, $mode)) {
                continue;
            }

            $manipulator = clone $original;

            $manipulator->$mode($w, $h);

            $encoded = $manipulator->encode(null, 100);

            file_put_contents('/tmp/tmp', $encoded);

            $fileInfo = new UploadedFile('/tmp/tmp', $file->original_name);

            $data = $adapter->upload('resizes', $fileInfo);

            Resize::unguard();
            Resize::create(array_merge($data, [
                'mode' => $mode,
                'file_id' => $file->id,
                'original_name' => $file->original_name,
            ]));
        }

    }

}