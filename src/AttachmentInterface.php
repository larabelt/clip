<?php
namespace Belt\Clip;

interface AttachmentInterface
{
    public function adapter();

    public function getSrcAttribute();

    public function getSecureAttribute();

    public function getContentsAttribute();

    public function getRelPathAttribute();

    public function setDriverAttribute($value);

    public function setNameAttribute($value);

    public function setOriginalNameAttribute($value);

    public function setMimetypeAttribute($value);

    public function setWidthAttribute($value);

    public function setHeightAttribute($value);

    public static function createFromUpload(array $attributes = []);

}