<?php
namespace Belt\Clip\Adapters;

use Belt\Clip\AttachmentInterface;
use Illuminate\Http\UploadedFile;

/**
 * Interface AdapterInterface
 * @package Belt\Clip\Adapters
 */
interface AdapterInterface
{

    /**
     * @param AttachmentInterface $file
     * @return mixed
     */
    public function src(AttachmentInterface $file);

    /**
     * @param AttachmentInterface $file
     * @return mixed
     */
    public function secure(AttachmentInterface $file);

    /**
     * @param AttachmentInterface $file
     * @return mixed
     */
    public function contents(AttachmentInterface $file);

    /**
     * @param $path
     * @param $filename
     * @return mixed
     */
    public function prefixedPath($path, $filename);

    /**
     * @param $path
     * @param UploadedFile $fileInfo
     * @param null $filename
     * @return mixed
     */
    public function upload($path, UploadedFile $fileInfo, $filename = null);

}