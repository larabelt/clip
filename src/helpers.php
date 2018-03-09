<?php

use Belt\Clip\Attachment;
use Belt\Clip\Helpers\ClipHelper;

if (!function_exists('clip')) {
    /**
     * @codeCoverageIgnore
     */
    function clip(Attachment $attachment)
    {
        return new ClipHelper($attachment);
    }
}