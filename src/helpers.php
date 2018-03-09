<?php

use Belt\Clip\Helpers\ClipHelper;

if (!function_exists('clip')) {
    function clip()
    {
        return new ClipHelper();
    }
}