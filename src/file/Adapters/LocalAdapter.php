<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Ohio\Storage\File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

class LocalAdapter extends BaseAdapter implements AdapterInterface
{
    /**
     * @var Filesystem
     */
    public $disk;

    public function src(File\FileInterface $file)
    {
        return sprintf('%s/%s', $this->config('src.root'), $file->rel_path);
    }

    public function secure(File\FileInterface $file)
    {
        return sprintf('%s/%s', $this->config('secure.root'), $file->rel_path);
    }

    public function contents(File\FileInterface $file)
    {
        return $this->disk->get($file->rel_path);
    }

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