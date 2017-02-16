<?php
namespace Belt\Clip\Behaviors;

interface FileableInterface
{

    public static function getResizePresets();

    public function files();

}