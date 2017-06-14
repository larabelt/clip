<?php

namespace Belt\Clip\Services;

use Belt\Core\Behaviors\HasDisk;
use Belt\Core\Behaviors\HasConsole;
use Belt\Clip\Adapters;
use Belt\Clip\Attachment;
use Illuminate\Http\UploadedFile;

/**
 * Class MoveService
 * @package Belt\Clip\Services
 */
class MoveService
{
    use HasConsole;
    use HasDisk;

    /**
     * @var Adapters\BaseAdapter[]
     */
    public $adapters;

    /**
     * @var Attachment
     */
    public $attachments;

    /**
     * MoveService constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->attachments = new Attachment();
        $this->console = array_get($options, 'console');
    }

    /**
     * @return Adapters\BaseAdapter
     */
    public function adapter($driver)
    {
        return $this->adapters[$driver] ?? $this->adapters[$driver] = Adapters\AdapterFactory::up($driver);
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
     */
    public function move($source, $target, $options = [])
    {
        $qb = $this->attachments->where('driver', $source)
            ->orderBy('updated_at');

        if ($ids = array_get($options, 'ids')) {
            $qb->whereIn('id', explode(',', $ids));
        }

        if ($limit = array_get($options, 'limit')) {
            $qb->take($limit);
        }

        $attachments = $qb->get();

        Attachment::unguard();

        foreach ($attachments as $attachment) {

            $this->log(sprintf('source: (#%s) %s', $attachment->id, $attachment->src));

            $adapter = $this->adapter($target);

            try {

                /**
                 * create tmp file from url to instantiate UploadedFile
                 */
                $tmp = tmpfile();
                $tmp_uri = array_get(stream_get_meta_data($tmp), 'uri');
                //fwrite($tmp, file_get_contents($attachment->src));
                fwrite($tmp, $attachment->contents);

                $file = new UploadedFile($tmp_uri, $attachment->name);

                $data = $adapter->upload($options['path'] ?? $attachment->path, $file);

                if ($data) {
                    $attachment->update($data);
                    $this->log('target: ' . $attachment->src);
                } else {
                    throw new \Exception();
                }

                fclose($tmp); // this removes the file

            } catch (\Exception $e) {
                $this->log('target: failed', 'warn');
                $attachment->touch();
                continue;
            }

        }
    }

}