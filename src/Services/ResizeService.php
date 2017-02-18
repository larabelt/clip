<?php
namespace Belt\Clip\Services;

use Belt\Clip\Adapters;
use Belt\Clip\Attachment;
use Belt\Clip\Resize;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

/**
 * Class ResizeService
 * @package Belt\Clip\Services
 */
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
     * @var Attachment
     */
    public $attachments;

    /**
     * @var ImageManager
     */
    public $manager;

    /**
     * @var Resize
     */
    public $resizeRepo;

    /**
     * ResizeService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = array_merge(config('belt.clip.resize'), $config);
        $this->attachments = new Attachment();
    }

    /**
     * @param null $key
     * @param bool $default
     * @return array|mixed
     */
    public function config($key = null, $default = false)
    {
        if ($key) {
            return array_get($this->config, $key, $default);
        }

        return $this->config;
    }

    /**
     * @return Adapters\BaseAdapter
     */
    public function adapter()
    {
        return $this->adapter ?: $this->adapter = Adapters\AdapterFactory::up($this->config('local_driver'));
    }

    /**
     * @return ImageManager
     */
    public function manager()
    {
        return $this->manager ?: $this->manager = new ImageManager([
            'driver' => $this->config('image_driver'),
        ]);
    }

    /**
     * @return Resize
     */
    public function resizeRepo()
    {
        return $this->resizeRepo ?: $this->resizeRepo = new Resize();
    }

    /**
     *
     */
    public function batch()
    {
        $models = $this->config('models');

        foreach ($models as $model) {

            $presets = $model::getResizePresets();

            $attachments = $this->query($model, $presets);

            foreach ($attachments as $attachment) {
                $attachment = $this->attachments->find($attachment->id);
                $this->resize($attachment, $presets);
            }

        }
    }

    /**
     * @param $class
     * @param $presets
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function query($class, $presets)
    {

        $qb1 = $this->attachments->query();
        $qb1->select(['attachments.id']);
        $qb1->take(100);

        $qb1->join('clippables', function ($qb2) use ($class) {
            $qb2->on('clippables.attachment_id', '=', 'attachments.id');
            $qb2->where('clippables.clippable_type', (new $class)->getMorphClass());
        });

        foreach ($presets as $n => $preset) {
            $alias = "preset$n";
            $qb1->leftJoin("attachment_resizes as $alias", function ($qb2) use ($alias, $preset) {
                $qb2->on("$alias.attachment_id", '=', 'attachments.id');
                $qb2->where("$alias.width", $preset[0]);
                $qb2->where("$alias.height", $preset[1]);
            });
            $qb1->orWhereNull("$alias.id");
        }

        $attachments = $qb1->get();

        return $attachments;
    }

    /**
     * @param Attachment $attachment
     * @param array $presets
     */
    public function resize(Attachment $attachment, $presets = [])
    {
        $adapter = $this->adapter ?: $attachment->adapter();

        $original = $this->manager()->make($attachment->contents);

        foreach ($presets as $preset) {

            $w = $preset[0];
            $h = $preset[1];

            if ($attachment->__sized($w, $h)) {
                continue;
            }

            $mode = array_get($preset, 2, 'fit');

            $manipulator = clone $original;
            $manipulator->$mode($w, $h);

            $encoded = $manipulator->encode(null, 100);

            file_put_contents('/tmp/tmp', $encoded);

            $attachmentInfo = new UploadedFile('/tmp/tmp', $attachment->original_name);

            $data = $adapter->upload('resizes', $attachmentInfo);

            $this->resizeRepo()->unguard();
            $this->resizeRepo()->create(array_merge($data, [
                'mode' => $mode,
                'attachment_id' => $attachment->id,
                'original_name' => $attachment->original_name,
            ]));
        }

    }

}