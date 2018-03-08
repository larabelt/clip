<?php

namespace Belt\Clip\Adapters;

use Storage;
use Belt\Core\Behaviors\HasConfig;
use Belt\Clip\AttachmentInterface;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Http\UploadedFile;

/**
 * Class BaseAdapter
 * @package Belt\Clip\Adapters
 */
abstract class BaseAdapter
{

    use HasConfig;

    /**
     * @var
     */
    public $driver;

    /**
     * @var FilesystemContract
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

        $this->setConfig(config("belt.clip.drivers.$driver"));

        if (!$this->config('disk') || !$this->disk = Storage::disk($this->config('disk'))) {
            throw new \Exception('disk for adapter not specified or available');
        }
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
     * @param AttachmentInterface $file
     * @return string
     */
    public function src(AttachmentInterface $file)
    {
        if ($rel_path = $file->rel_path) {
            return sprintf('%s/%s', $this->config('src.root'), $rel_path);
        }

        return null;
    }

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function secure(AttachmentInterface $file)
    {

        if ($rel_path = $file->rel_path) {
            return sprintf('%s/%s', $this->config('secure.root'), $rel_path);
        }

        return null;
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

    /**
     * Get attributes of existing file
     *
     * @param $path
     * @return array|null
     */
    public function getFromPath($path, $filename = null)
    {

        $filename = $filename ?: basename($path);
        $path = str_replace("/$filename", '', $path);
        $root = config("filesystems.disks.$this->driver.root");

        if ($this->disk->exists("$path/$filename")) {
            $fileInfo = new UploadedFile("$root/$path/$filename", $filename);
            return $this->__create($path, $fileInfo, $filename);
        }

        return null;
    }

}