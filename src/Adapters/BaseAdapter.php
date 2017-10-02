<?php

namespace Belt\Clip\Adapters;

use Storage;
use Illuminate\Http\UploadedFile;

/**
 * Class BaseAdapter
 * @package Belt\Clip\Adapters
 */
abstract class BaseAdapter
{

    /**
     * @var
     */
    public $driver;

    /**
     * @var array
     */
    public $config = [];


    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $disk;

    /**
     * BaseAdapter constructor.
     * @param $driver
     * @throws \Exception
     */
    public function __construct($driver)
    {

        $this->driver = $driver;

        $this->config = config("belt.clip.drivers.$driver");

        if (!$this->config('disk') || !$this->disk = Storage::disk($this->config('disk'))) {
            throw new \Exception('disk for adapter not specified or available');
        }
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
     * @param $fileInfo
     * @param boolean $force
     * @return string
     */
    public function randomFilename($fileInfo, $force = false)
    {

        if (!$force) {
            try {
                $original = $fileInfo->getClientOriginalName();
            } catch (\Exception $e) {

            }

            if (isset($original)) {

                // remove extension and clean up name
                $sanitized = preg_replace('/\\.[^.\\s]{3,4}$/', '', $original);
                $sanitized = str_slug(strtolower($sanitized));

                return sprintf('%s-%s.%s', date('YmdHis'), $sanitized, $fileInfo->guessExtension());
            }
        }

        return sprintf('%s-%s.%s', date('YmdHis'), uniqid(), $fileInfo->guessExtension());
    }

    /**
     * @todo move to UrlHelper
     * @param $path
     * @return string
     */
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

    /**
     * @param $path
     * @param null $filename
     * @return string
     */
    public function prefixedPath($path, $filename = null)
    {
        $prefix = $this->config('prefix');

        $path = $this->normalizePath("$prefix/$path");

        return $filename ? "$path/$filename" : $path;
    }

    /**
     * @param $path
     * @param UploadedFile $uploadedFile
     * @param null $filename
     * @return array
     */
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
            'original_name' => $uploadedFile->getClientOriginalName(),
            'path' => "$path",
            'size' => $uploadedFile->getSize(),
            'mimetype' => $uploadedFile->getMimeType(),
            'width' => $sizes ? $sizes[0] : null,
            'height' => $sizes ? $sizes[1] : null,
        ];
    }

}