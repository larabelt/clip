<?php
namespace Belt\Clip\Adapters;

use Belt\Clip\AttachmentInterface;
use Illuminate\Http\UploadedFile;

interface AdapterInterface
{

    public function src(AttachmentInterface $file);

    public function secure(AttachmentInterface $file);

    public function contents(AttachmentInterface $file);

    public function prefixedPath($path, $filename);

    public function upload($path, UploadedFile $fileInfo, $filename = null);

}