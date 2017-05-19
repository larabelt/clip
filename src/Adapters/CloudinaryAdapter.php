<?php

namespace Belt\Clip\Adapters;

use Cloudinary, League\Flysystem\Util;
use Belt\Clip\AttachmentInterface;
use Belt\Clip\Services\Cloudinary\CloudinaryFlysystemAdapter;
use Illuminate\Http\UploadedFile;

/**
 * Class LocalAdapter
 * @package Belt\Clip\Adapters
 */
class CloudinaryAdapter extends BaseAdapter implements AdapterInterface
{

    /**
     * @var CloudinaryFlysystemAdapter
     */
    public $diskAdapter;

    /**
     * @return CloudinaryFlysystemAdapter
     */
    public function diskAdapter()
    {
        return $this->diskAdapter ?: $this->diskAdapter = $this->disk->getDriver()->getAdapter();
    }

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function src(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('src.root'), $file->rel_path);
    }

    /**
     * @param AttachmentInterface $file
     * @return string
     */
    public function secure(AttachmentInterface $file)
    {
        return sprintf('%s/%s', $this->config('secure.root'), $file->rel_path);
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
        $filename = pathinfo($filename, PATHINFO_FILENAME);

        $path = $this->prefixedPath($path);

        if ($result = $this->disk->putFileAs($path, $fileInfo, $filename)) {
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
        $data = parent::__create($path, $uploadedFile, $filename);

        $response = $this->diskAdapter()->getResponse();
        $data['path'] = array_get($response, 'rel_path', $path);
        $data['name'] = array_get($response, 'basename', $path);

        return $data;
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