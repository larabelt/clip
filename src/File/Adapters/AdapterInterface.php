<?php
namespace Ohio\Storage\File\Adapters;

use Storage;
use Ohio\Storage\File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

interface AdapterInterface
{

    public function src(File\FileInterface $file);

    public function secure(File\FileInterface $file);

    public function contents(File\FileInterface $file);

    public function prefixedPath($path, $filename);

    public function upload($path, UploadedFile $fileInfo, $filename = null);

}