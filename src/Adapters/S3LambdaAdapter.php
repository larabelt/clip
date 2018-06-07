<?php

namespace Belt\Clip\Adapters;

use Belt\Clip\Helpers\ClipHelper;
use Belt\Clip\Helpers\SrcHelper;

/**
 * Class S3Adapter
 * @package Belt\Clip\Adapters
 */
class S3LambdaAdapter extends BaseAdapter implements AdapterInterface
{
    /**
     * @param $driver
     */
    public static function loadMacros($driver)
    {
        if (!SrcHelper::hasMacro($driver)) {
            SrcHelper::macro($driver, function (ClipHelper $helper) {

                $attachment = $helper->getAttachment();
                $adapter = $attachment->adapter();
                $w = $helper->param('width');
                $h = $helper->param('height');

                $src = $attachment->src;

                if ($w || $h) {
                    $resizeDir = sprintf('%sx%s', $w, $h);
                    $src = BaseAdapter::normalizePath([
                        $adapter->config('src.root'),
                        $resizeDir,
                        $attachment->path,
                        $attachment->name,
                    ]);
                }

                $src = str_replace(['http://', 'https://', 'http:/', 'https:/'], '//', $src);

                return $src;
            });
        }
    }

}