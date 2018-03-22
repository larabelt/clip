<?php

namespace Belt\Clip\Services;

use Belt, Morph;
use Belt\Core\Behaviors\TmpFile;
use Belt\Core\Behaviors\HasDisk;
use Belt\Core\Behaviors\HasConsole;
use Belt\Clip\Adapters;
use Belt\Clip\Attachment;
use Belt\Clip\Jobs\MoveAttachment;
use Illuminate\Http\UploadedFile;

/**
 * Class MoveService
 * @package Belt\Clip\Services
 */
class MoveService
{
    use HasConsole, HasDisk, TmpFile;

    /**
     * @var resource|bool a file handle
     */
    public $tmpFile;

    /**
     * MoveService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->console = array_get($options, 'console');
    }

    /**
     * @param $message
     * @param string $type
     */
    public function log($message, $type = 'info')
    {
        $path = sprintf('storage/logs/moved-files/%s.log', date('Y-m-d'));

        $this->disk()->append($path, $message);

        $this->$type($message);
    }

    /**
     * @param $source
     * @param $target
     * @param array $options
     * @throws \Exception
     */
    public function run($source, $target, $options = [])
    {
        $qb = Morph::type2QB('attachments')
            ->where('driver', $source)
            ->orderBy('updated_at');

        if ($ids = array_get($options, 'ids')) {
            $qb->whereIn('id', explode(',', $ids));
        }

        if ($limit = array_get($options, 'limit')) {
            $qb->take($limit);
        }

        $queue = array_get($options, 'queue', false);
        foreach ($qb->get() as $attachment) {
            if ($queue) {
                dispatch(new MoveAttachment($attachment, $target, $options));
            } else {
                $this->move($attachment, $target, $options);
            }
        }
    }

    /**
     * @param Attachment $attachment
     * @param $target
     * @param $options
     * @throws \Exception
     */
    public function move(Attachment $attachment, $target, $options)
    {
        $this->log(sprintf('source: (#%s) %s', $attachment->id, $attachment->src));

        $adapter = Adapters\AdapterFactory::up($target);
        $adapter->mergeConfig(['prefix' => '']);

        Attachment::unguard();

        try {

            $this->createTmpFile($attachment);

            $file = new UploadedFile(array_get(stream_get_meta_data($this->tmpFile), 'uri'), $attachment->name);

            $path = is_null(array_get($options, 'path')) ? $attachment->path : array_get($options, 'path');

            $data = $adapter->upload($path, $file, $attachment->name);

            if ($data) {
                $attachment->update($data);
                $this->log('target: ' . $attachment->src);
            } else {
                throw new \Exception('move attachment upload failed');
            }


        } catch (\Exception $e) {
            $this->log('target: failed', 'warn');
            $attachment->touch();
        }
    }

}