<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Ohio\Storage\File;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File as LaravelFile;

class LocalAdapter extends BaseAdapter implements AdapterInterface
{
    /**
     * @var FilesystemAdapter
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

    /**
     * @param $path
     * @param UploadedFile $fileInfo
     * @param null $filename
     * @return array|nullif ($file instanceof UploadedFile) {
    $file = file_get_contents($file->getRealPath());
    }

    $filename = array_get($params, 'filename', sprintf('%s-%s', strtotime('now'), uniqid()));

    $result = $this->disk->put($filename, $file);
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