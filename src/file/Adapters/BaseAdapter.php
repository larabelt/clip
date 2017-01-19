<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Ohio\Storage\File\File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

class BaseAdapter
{

    public $key;

    public $config = [];

    public $http;

    public $https;

    /**
     * @var Filesystem
     */
    public $disk;

    /**
     * @var File
     */
    public $files;

    public function __construct($disk)
    {
        $this->key = $disk;

        $this->disk = Storage::disk($disk);

        $this->config = array_merge(
            config("filesystems.disks.$disk"),
            config("ohio.storage.disks.$disk")
        );

        $appUrl = env('APP_URL', url());

        $this->http = array_get($this->config, 'http', $appUrl);

        $this->https = array_get($this->config, 'https', $appUrl);

        $this->files = new File();
    }

    public function src(File $file)
    {
        return sprintf('%s/%s', $this->http, $file->web_path);
    }

    public function secure(File $file)
    {
        return sprintf('%s/%s', $this->https, $file->web_path);
    }

    public function randomFilename($fileInfo)
    {
        return sprintf('%s.%s', uniqid(), $fileInfo->guessExtension());
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

        $rel_path = $this->normalizePath($rel_path);

        return $rel_path ? "$rel_path/$filename" : $filename;
    }

    public function relativeWebPath($rel_path, $filename)
    {
        $prefix = array_get($this->config, 'web_prefix', '');

        $rel_path = $this->normalizePath("$prefix/$rel_path");

        return $rel_path ? "$rel_path/$filename" : $filename;
    }


    public function create($input)
    {

        File::unguard();

        $file = $this->files->create([
            'disk' => $this->key,
            'name' => $input['name'],
            'original_name' => $input['original_name'],
            'file_path' => $input['file_path'],
            'web_path' => $input['web_path'],
            'size' => $input['size'],
            'mimetype' => $input['mimetype'],
            'width' => $input['width'],
            'height' => $input['height'],
        ]);

        return $file;
    }

    public function __create($rel_path, UploadedFile $uploadedFile, $filename)
    {

        $sizes = [];
        if (strpos($uploadedFile->getMimeType(), 'image/') !== false) {
            $sizes = getimagesize($uploadedFile->getRealPath());
        }

        return [
            'disk' => 'public',
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