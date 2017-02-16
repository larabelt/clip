<?php
namespace Belt\Clip\Adapters;

use Storage;
use Belt\Clip\AttachmentInterface;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File as LaravelFile;

class LocalAdapter extends BaseAdapter implements AdapterInterface
{
    /**
     * @var FilesystemAdapter
     */
    public $disk;

    public function src(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('src.root'), $file->rel_path);
    }

    public function secure(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('secure.root'), $file->rel_path);
    }

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