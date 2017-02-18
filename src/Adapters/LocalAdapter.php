<?php
namespace Belt\Clip\Adapters;

use Belt\Clip\AttachmentInterface;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;

/**
 * Class LocalAdapter
 * @package Belt\Clip\Adapters
 */
class LocalAdapter extends BaseAdapter implements AdapterInterface
{
    /**
     * @var FilesystemAdapter
     */
    public $disk;

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function src(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('src.root'), $file->rel_path);
    }

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function secure(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('secure.root'), $file->rel_path);
    }

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function contents(AttachmentInterface $file)
    {
        return $this->disk->get($file->rel_path);
    }

    /**
     * @param $path
     * @param UploadedFile $fileInfo
     * @param null $filename
     * @return array|null
     */

    public function upload($path, UploadedFile $fileInfo, $filename = null)
    {

        $filename = $filename ?: $this->randomFilename($fileInfo);

        $path = $this->prefixedPath($path);

        if ($this->disk->putFileAs($path, $fileInfo, $filename)) {
            return $this->__create($path, $fileInfo, $filename);
        }

        return null;
    }

}