<?php
namespace Belt\Storage\Adapters;

use Storage;
use Illuminate\Http\UploadedFile;

abstract class BaseAdapter
{

    public $driver;

    /**
     * @var array
     */
    public $config = [];


    public $disk;

    public function __construct($driver)
    {

        $this->driver = $driver;

        $this->config = config("belt.storage.drivers.$driver");

        if (!$this->config('disk') || !$this->disk = Storage::disk($this->config('disk'))) {
            throw new \Exception('disk for adapter not specified or available');
        }
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

    public function prefixedPath($path, $filename = null)
    {
        $prefix = $this->config('prefix');

        $path = $this->normalizePath("$prefix/$path");

        return $filename ? "$path/$filename" : $path;
    }

    public function __create($path, UploadedFile $uploadedFile, $filename = null)
    {
        $filename = $filename ?: $uploadedFile->getFilename();

        $sizes = [];
        if (strpos($uploadedFile->getMimeType(), 'image/') !== false) {
            $sizes = getimagesize($uploadedFile->getRealPath());
        }

        return [
            'driver' => $this->driver,
            'name' => $filename,
            'original_name' => $uploadedFile->getFilename(),
            'path' => "$path",
            'size' => $uploadedFile->getSize(),
            'mimetype' => $uploadedFile->getMimeType(),
            'width' => $sizes ? $sizes[0] : null,
            'height' => $sizes ? $sizes[1] : null,
        ];
    }

}