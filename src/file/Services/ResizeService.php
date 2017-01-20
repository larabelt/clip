<?php
namespace Ohio\Storage\File\Services;

use Ohio\Storage\File\Adapters;
use Ohio\Storage\File\File;
use Intervention\Image\ImageManager;
use Ohio\Storage\File\Resize;

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
        return $this->adapter ?: $this->adapter = Adapters\AdapterFactory::up($this->config('disk'));
    }

    public function manager()
    {
        return $this->manager ?: $this->manager = new ImageManager([
            'driver' => $this->config('driver'),
        ]);
    }

    public function resizeRepo()
    {
        return $this->resizeRepo ?: $this->resizeRepo = new Resize();
    }

    public function resize(File $file)
    {
        $disk = $file->adapter()->disk;

        $original = $this->manager()->make($file->contents);

        foreach ($this->presets() as $preset => $params) {

            s($preset);
            s($params);

            $count = $this->resizeRepo()->where([
                'file_id' => $file->id,
                'preset' => $preset,
            ])->count();

            if ($count) {
                continue;
            }

            s('none');

            $manipulator = clone $original;

            $w = $params[0];
            $h = $params[1];

            // do a smart resize that crops the image and avoids distortion
            $manipulator->fit($w, $h);

            $encoded = $manipulator->encode(null, 100);

            $input = [
                'file_id' => $file->id,
                'preset' => $preset,
                'file' => $encoded,
            ];

            //need data set
            //upload
            //save resize...

//            $input = File\Task\UploadFile::run($input);
//
//            if (array_get($input, 'src')) {
//                $resizeRepository->store($input);
//            }

        }


    }

}