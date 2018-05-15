<?php

namespace Belt\Clip\Adapters;

//use Morph;
//use Belt\Clip\Adapters\BaseAdapter;
//use Belt\Clip\Resize;
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
//                Resize::unguard();
//                $qb = Morph::type2QB('attachment_resizes');
//                $qb->firstOrCreate([
//                    'attachment_id' => $attachment->id,
//                    'width' => $w,
//                    'height' => $h,
//                ]);
//                $qb->update(array_merge(
//                    array_only($attachment->toArray(), [
//                        'driver',
//                        'mimetype',
//                        'name',
//                        'original_name',
//                    ]),
//                    [
//                        'mode' => 'default',
//                        'path' => BaseAdapter::normalizePath([$resizeDir, $attachment->path]),
//                    ]));
            });
        }
    }

}