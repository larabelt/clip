<?php

namespace Belt\Clip\Helpers;

use Belt\Clip\AttachmentInterface;
use Illuminate\Support\Traits\Macroable;

/**
 * Class ClipHelper
 * @package Belt\Core\Helpers
 */
class ClipHelper
{
    use Macroable;

    /**
     * @var array
     */
    public $params = [];

    /**
     * @param $options
     * @return array
     */
    public function setParams($options)
    {
        $this->params = $params = [];

        foreach ($options as $option) {
            if ($option instanceof AttachmentInterface) {
                $params['attachment'] = $option;
            }
            if (is_numeric($option) || (!$option && !is_array($option))) {
                $key = isset($params['width']) ? 'height' : 'width';
                $params[$key] = $option ?: false;
            }
            if (is_array($option)) {
                $params = array_merge($params, $option);
            }
        }

        if (array_get($params, 'proportionallyResize')) {
            $attachment = array_get($params, 'attachment');
            $w = array_get($params, 'width');
            $h = array_get($params, 'height');
            if ($attachment && ($w || $h) && (!$w || !$h)) {
                list($params['width'], $params['height']) = static::proportionallyResize(
                    $attachment->width,
                    $attachment->height,
                    $w,
                    $h
                );
            }
        }

        return $this->params = $params;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function param($key, $default = null)
    {
        return array_get($this->params, $key, $default);
    }

    /**
     * @param $old_width
     * @param $old_height
     * @param bool $new_width
     * @param bool $new_height
     * @return array|bool
     */
    public static function proportionallyResize($old_width, $old_height, $new_width = false, $new_height = false)
    {
        $old_aspect_ratio = $old_width / $old_height;

        if (!$new_width && !$new_height) {
            return false;
        } elseif (!$new_width) {
            $new_width = $new_height * $old_aspect_ratio;
        } elseif (!$new_height) {
            $new_height = $new_width / $old_aspect_ratio;
        }

        $new_aspect_ratio = $new_width / $new_height;

        if ($new_aspect_ratio == $old_aspect_ratio) {

        } elseif ($new_aspect_ratio < $old_aspect_ratio) {
            $new_height = $new_width / $old_aspect_ratio;
        } elseif ($new_aspect_ratio > $old_aspect_ratio) {
            $new_width = $new_height * $old_aspect_ratio;
        }

        return [
            round($new_width),
            round($new_height)
        ];
    }

    public function src(AttachmentInterface $attachment, $w = null, $h = null, $params = [])
    {


        $params = $this->setParams([$attachment, $w, $h, $params, ['proportionallyResize' => true]]);

        $driver = $attachment->driver;


//        static::macro($driver, function ($helper) {
//
//            $params = $helper->params;
//
//            $attachment = array_get($params, 'attachment');
//            $adapter = $attachment->adapter();
//            $w = array_get($params, 'width');
//            $h = array_get($params, 'height');
//
//            $src = sprintf('%s/%sx%s/%s?v=1', $adapter->config('src.root'), $w, $h, $attachment->rel_path);
//
//            return $src;
//        });




        if ($this->hasMacro($driver)) {
            return $this->__call($driver, [$this]);
        }

        return $attachment->format($params);
    }

}