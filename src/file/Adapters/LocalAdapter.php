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

    //@todo
    public function __construct($disk)
    {
        $this->key = $disk;

        $this->disk = Storage::disk($disk);

        $this->config = array_merge(
            config("filesystems.disks.$disk"),
            config("ohio.storage.disks.$disk")
        );
    }

    public function src(File\FileInterface $file)
    {
        return sprintf('%s/%s', $this->config('http'), $file->web_path);
    }

    public function secure(File\FileInterface $file)
    {
        return sprintf('%s/%s', $this->config('https'), $file->web_path);
    }

    public function contents(File\FileInterface $file)
    {
        return $this->disk->get($file->file_path);
    }



    public function upload($rel_path, UploadedFile $fileInfo, $filename = null)
    {

        $rel_path = $this->normalizePath($rel_path);

        $filename = $filename ?: $this->randomFilename($fileInfo);

        if ($this->disk->putFileAs($rel_path, $fileInfo, $filename)) {
            return $this->__create($rel_path, $fileInfo, $filename);
        }

        return null;
    }

}