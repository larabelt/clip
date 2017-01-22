<?php
namespace Ohio\Storage\File;

use Ohio\Storage\File\Adapters\BaseAdapter;
use Ohio\Storage\File\Adapters\AdapterFactory;

interface FileInterface
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