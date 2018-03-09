<?php

namespace Belt\Clip\Adapters;

use Belt\Clip\AttachmentInterface;
use Belt\Clip\Helpers\ClipHelper;

/**
 * Class S3Adapter
 * @package Belt\Clip\Adapters
 */
class S3Adapter extends BaseAdapter implements AdapterInterface
{
    public function __construct($driver)
    {
        parent::__construct($driver);

        ClipHelper::macro($driver, function ($helper) {

            $params = $helper->params;

            $attachment = array_get($params, 'attachment');
            $adapter = $attachment->adapter();
            $w = array_get($params, 'width');
            $h = array_get($params, 'height');

            $src = sprintf('%s/%sx%s/%s?v=2', $adapter->config('src.root'), $w, $h, $attachment->rel_path);

            return $src;
        });
    }

    /**
     * @param AttachmentInterface $file
     * @param array $params
     * @return string
     */
    public function format(AttachmentInterface $file, $params = [])
    {
        $w = array_get($params, 'width');
        $h = array_get($params, 'height');

        $src = sprintf('%s/%sx%s/%s', $this->config('src.root'), $w, $h, $file->rel_path);

        return $src;
    }
}