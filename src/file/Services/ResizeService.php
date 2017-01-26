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
     * @var File
     */
    public $files;

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
        $this->files = new File();
    }

    public function config($key = null, $default = false)
    {
        if ($key) {
            return array_get($this->config, $key, $default);
        }

        return $this->config;
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

    public function batch()
    {
        $models = $this->config('models');

        foreach ($models as $model) {

            $presets = $model::getResizePresets();

            $files = $this->query($model, $presets);

            foreach ($files as $file) {
                $file = $this->files->find($file->id);
                $this->resize($file, $presets);
            }

        }
    }

    public function query($class, $presets)
    {

        $qb1 = $this->files->query();
        $qb1->select(['files.id']);
        $qb1->take(100);

        $qb1->join('fileables', function ($qb2) use ($class) {
            $qb2->on('fileables.file_id', '=', 'files.id');
            $qb2->where('fileables.fileable_type', (new $class)->getMorphClass());
        });

        foreach ($presets as $n => $preset) {
            $alias = "preset$n";
            $qb1->leftJoin("file_resizes as $alias", function ($qb2) use ($alias, $preset) {
                $qb2->on("$alias.file_id", '=', 'files.id');
                $qb2->where("$alias.width", $preset[0]);
                $qb2->where("$alias.height", $preset[1]);
            });
            $qb1->orWhereNull("$alias.id");
        }

        $files = $qb1->get();

        return $files;
    }

    public function resize(File $file, $presets = [])
    {
        $adapter = $this->adapter ?: $file->adapter();

        $original = $this->manager()->make($file->contents);

        foreach ($presets as $preset) {

            $w = $preset[0];
            $h = $preset[1];

            if ($file->__sized($w, $h)) {
                continue;
            }

            $mode = array_get($preset, 2, 'fit');

            $manipulator = clone $original;
            $manipulator->$mode($w, $h);

            $encoded = $manipulator->encode(null, 100);

            file_put_contents('/tmp/tmp', $encoded);

            $fileInfo = new UploadedFile('/tmp/tmp', $file->original_name);

            $data = $adapter->upload('resizes', $fileInfo);

            $this->resizeRepo()->unguard();
            $this->resizeRepo()->create(array_merge($data, [
                'mode' => $mode,
                'file_id' => $file->id,
                'original_name' => $file->original_name,
            ]));
        }

    }

}