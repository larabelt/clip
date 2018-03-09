<?php

namespace Belt\Clip\Helpers;

use Belt\Clip\Attachment;
use Belt\Clip\Helpers\SrcHelper;

/**
 * Class ClipHelper
 * @package Belt\Core\Helpers
 */
class ClipHelper
{

    /**
     * @var Attachment
     */
    private $attachment;

    /**
     * @var array
     */
    public $params = [];

    /**
     * ClipHelper constructor.
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->setAttachment($attachment);
    }

    /**
     * @param Attachment $attachment
     */
    public function setAttachment(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return Attachment
     */
    public function getAttachment()
    {
        $this->attachment->adapter();

        return $this->attachment;
    }

    /**
     * @param $options
     * @return array
     */
    public function setParams($options)
    {
        $this->params = $params = [];

        foreach ($options as $option) {
            if (is_numeric($option) || (!$option && !is_array($option))) {
                $key = isset($params['width']) ? 'height' : 'width';
                $params[$key] = $option ?: false;
            }
            if (is_array($option)) {
                $params = array_merge($params, $option);
            }
        }

        if (array_get($params, 'proportionallyResize')) {
            $attachment = $this->getAttachment();
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
        $old_ratio = $old_width / $old_height;

        if (!$new_width && !$new_height) {
            return false;
        }

        $new_width = $new_width ?: $new_height * $old_ratio;
        $new_height = $new_height ?: $new_width / $old_ratio;

        $new_ratio = $new_width / $new_height;
        if ($new_ratio < $old_ratio) {
            $new_height = $new_width / $old_ratio;
        }
        if ($new_ratio > $old_ratio) {
            $new_width = $new_height * $old_ratio;
        }

        return [
            (int) round($new_width),
            (int) round($new_height),
        ];
    }

    /**
     * @param null $w
     * @param null $h
     * @param array $params
     * @return mixed
     */
    public function src($w = null, $h = null, $params = [])
    {
        $this->setParams([$w, $h, $params, ['proportionallyResize' => true]]);

        $attachment = $this->getAttachment();
        $w = $this->param('width');
        $h = $this->param('height');

        $src = null;

        if ($resized = $attachment->__sized($w, $h)) {
            $src = $resized->src;
        }

        if (!$src) {
            $driver = $attachment->driver;
            if (SrcHelper::hasMacro($driver)) {
                $src = SrcHelper::$driver($this);
            }
        }

        return $src ?: $attachment->src;
//        $src = $src ?: $attachment->src;
//        $src = str_replace(['http://', 'https://', 'http:/', 'https:/'], '//', $src);
    }

}