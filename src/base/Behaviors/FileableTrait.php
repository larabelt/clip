<?php
namespace Ohio\Storage\Base\Behaviors;

use Ohio\Storage\File\File;

trait FileableTrait
{

    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

}