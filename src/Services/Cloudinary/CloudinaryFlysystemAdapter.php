<?php

namespace Belt\Clip\Services\Cloudinary;

use Cloudinary;
use League\Flysystem\Config;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\CanOverwriteFiles;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use League\Flysystem\Util;

/**
 * Class LocalAdapter
 * @package Belt\Clip\Adapters
 */
class CloudinaryFlysystemAdapter extends AbstractAdapter implements CanOverwriteFiles
{
    use NotSupportingVisibilityTrait;

    /** @var Cloudinary\Uploader */
    protected $uploader;

    /**
     * @var array
     */
    public $response;

    /**
     * @var array
     */
    public $config = [];

    public function __construct($config)
    {
        $this->config = $config;
        $this->uploader = new Cloudinary\Uploader();
        $this->setPathPrefix(array_get($config, 'root'));
    }

    /**
     * {@inheritdoc}
     */
    public function write($path, $contents, Config $config)
    {
        return $this->upload($path, $contents, 'add');
    }

    /**
     * {@inheritdoc}
     */
    public function writeStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, 'add');
    }

    /**
     * {@inheritdoc}
     */
    public function update($path, $contents, Config $config)
    {
        return $this->upload($path, $contents, 'overwrite');
    }

    /**
     * {@inheritdoc}
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->upload($path, $resource, 'overwrite');
    }

    /**
     * {@inheritdoc}
     */
    public function rename($path, $newPath): bool
    {
        $path = $this->applyPathPrefix($path);
        $newPath = $this->applyPathPrefix($newPath);

        try {

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function copy($path, $newpath): bool
    {
        $path = $this->applyPathPrefix($path);
        $newpath = $this->applyPathPrefix($newpath);

        try {
            $this->client->copy($path, $newpath);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path): bool
    {
        $location = $this->applyPathPrefix($path);

        try {

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteDir($dirname): bool
    {
        return $this->delete($dirname);
    }

    /**
     * {@inheritdoc}
     */
    public function createDir($dirname, Config $config)
    {
        $path = $this->applyPathPrefix($dirname);

        try {
            $object = $this->client->createFolder($path);
        } catch (\Exception $e) {
            return false;
        }

        return $this->normalizeResponse($object);
    }

    /**
     * {@inheritdoc}
     */
    public function has($path)
    {
        $file_exists = false;
        try {
            file_get_contents(cloudinary_url($path));
            $file_exists = true;
        } catch (\Exception $e) {

        }

        return $file_exists;
    }

    /**
     * {@inheritdoc}
     */
    public function read($path)
    {
        if (!$object = $this->readStream($path)) {
            return false;
        }

        $object['contents'] = stream_get_contents($object['stream']);
        fclose($object['stream']);
        unset($object['stream']);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function readStream($path)
    {
        $path = $this->applyPathPrefix($path);

        try {

        } catch (\Exception $e) {
            return false;
        }

        return compact('stream');
    }

    /**
     * {@inheritdoc}
     */
    public function listContents($directory = '', $recursive = false): array
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($path)
    {

        try {

        } catch (\Exception $e) {
            return false;
        }

        return $this->normalizeResponse([]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSize($path)
    {
        return $this->getMetadata($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getMimetype($path)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getTimestamp($path)
    {
        return $this->getMetadata($path);
    }

    /**
     * @param string $path
     * @param resource|string $contents
     * @param string $mode
     *
     * @return array|false file metadata
     */
    protected function upload(string $path, $contents, string $mode)
    {
        $this->response = [];

        $path = $this->applyPathPrefix($path);

        $tmp_path = $contents;
        if (is_resource($contents)) {
            $tmp_path = array_get(stream_get_meta_data($contents), 'uri', $contents);
        }

        try {
            $response = $this->uploader->upload($tmp_path, ['public_id' => $path]);
        } catch (\Exception $e) {
            return false;
        }

        return $this->normalizeResponse($response);
    }

    protected function normalizeResponse(array $response = [])
    {
        $url = array_get($response, 'url');
        if ($url) {

            $filename = basename($url);
            $base_path = sprintf( '%s/image/upload', array_get($this->config, 'cloud_name') );
            $rel_path_full = parse_url(str_replace($filename, '', $url), PHP_URL_PATH);
            $rel_path = str_replace($base_path, '', $rel_path_full);

            $info = Util::pathinfo($url);

            array_set($info, 'scheme', parse_url($url, PHP_URL_SCHEME));
            array_set($info, 'host', parse_url($url, PHP_URL_HOST));
            array_set($info, 'rel_path', Util::normalizeRelativePath($rel_path));
        }

        $this->response = array_merge($response, $info);

        return $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

}