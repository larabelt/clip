<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Ohio\Storage\File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

abstract class BaseAdapter
{

    public $key;

    /**
     * @var array
     */
    public $config = [];


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

    public function config($key = null, $default = false)
    {
        if ($key) {
            return array_get($this->config, $key, $default);
        }

        return $this->config;
    }

    public function randomFilename($fileInfo)
    {
        return sprintf('%s.%s', uniqid(), $fileInfo->guessExtension());
    }

    public function normalizePath($path)
    {

        $ds = DIRECTORY_SEPARATOR;

        if (is_array($path)) {
            $path = implode($ds, $path);
        }

        $path = ltrim($path, $ds);
        $path = rtrim($path, $ds);

        $bits = preg_split('@/@', $path, null, PREG_SPLIT_NO_EMPTY);

        $path = implode($ds, $bits);

        return $path;
    }

    public function relativeFilePath($rel_path, $filename)
    {
        $prefix = $this->config('file_prefix');

        $rel_path = $this->normalizePath("$prefix/$rel_path");

        return $rel_path ? "$rel_path/$filename" : $filename;
    }

    public function relativeWebPath($rel_path, $filename)
    {
        $prefix = $this->config('web_prefix');

        $rel_path = $this->normalizePath("$prefix/$rel_path");

        return $rel_path ? "$rel_path/$filename" : $filename;
    }

    public function __create($rel_path, UploadedFile $uploadedFile, $filename = null)
    {
        $filename = $filename ?: $uploadedFile->getFilename();

        $sizes = [];
        if (strpos($uploadedFile->getMimeType(), 'image/') !== false) {
            $sizes = getimagesize($uploadedFile->getRealPath());
        }

        return [
            'disk' => $this->key,
            'name' => $filename,
            'original_name' => $uploadedFile->getFilename(),
            'file_path' => $this->relativeFilePath($rel_path, $filename),
            'web_path' => $this->relativeWebPath($rel_path, $filename),
            'size' => $uploadedFile->getSize(),
            'mimetype' => $uploadedFile->getMimeType(),
            'width' => $sizes ? $sizes[0] : null,
            'height' => $sizes ? $sizes[1] : null,
        ];
    }

}