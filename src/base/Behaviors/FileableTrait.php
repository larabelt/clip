<?php
namespace Ohio\Storage\Base\Behaviors;

use Ohio\Storage\File\File;
use Rutorika\Sortable\MorphToSortedManyTrait;

trait FileableTrait
{

    use MorphToSortedManyTrait;

    public static function getResizePresets()
    {
        return isset(static::$presets) ? static::$presets : [];
    }

    public function files()
    {
        return $this->morphToSortedMany(File::class, 'fileable');
    }

}