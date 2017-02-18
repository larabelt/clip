<?php
namespace Belt\Clip\Behaviors;

/**
 * Interface ClippableInterface
 * @package Belt\Clip\Behaviors
 */
interface ClippableInterface
{

    /**
     * @return mixed
     */
    public static function getResizePresets();

    /**
     * @return mixed
     */
    public function attachments();

}