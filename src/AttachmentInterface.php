<?php
namespace Belt\Clip;

/**
 * Interface AttachmentInterface
 * @package Belt\Clip
 */
interface AttachmentInterface
{
    /**
     * @return mixed
     */
    public function adapter();

    /**
     * @return mixed
     */
    public function getSrcAttribute();

    /**
     * @return mixed
     */
    public function getSecureAttribute();

    /**
     * @return mixed
     */
    public function getContentsAttribute();

    /**
     * @return mixed
     */
    public function getRelPathAttribute();

    /**
     * @param $value
     * @return mixed
     */
    public function setDriverAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setNameAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setOriginalNameAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setMimetypeAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setWidthAttribute($value);

    /**
     * @param $value
     * @return mixed
     */
    public function setHeightAttribute($value);

    /**
     * @param array $attributes
     * @return mixed
     */
    public static function createFromUpload(array $attributes = []);

}