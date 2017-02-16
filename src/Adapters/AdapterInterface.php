<?php
namespace Belt\Clip\Adapters;

use Belt\Clip\FileInterface;
use Illuminate\Http\UploadedFile;

interface AdapterInterface
{

    public function src(FileInterface $file);

    public function secure(FileInterface $file);

    public function contents(FileInterface $file);

    public function prefixedPath($path, $filename);

    public function upload($path, UploadedFile $fileInfo, $filename = null);

}