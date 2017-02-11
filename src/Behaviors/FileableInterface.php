<?php
namespace Ohio\Storage\Behaviors;

interface FileableInterface
{

    public static function getResizePresets();

    public function files();

}