<?php
namespace Belt\Storage\Behaviors;

use Belt\Storage\File;
use Rutorika\Sortable\MorphToSortedManyTrait;

trait Fileable
{

    use MorphToSortedManyTrait;

    /**
     * @todo deprecate
     *
     * Eloquent renamed getBelongsToManyCaller to guessBelongsToManyRelation
     * and the package Rutorika\Sortable currently expects the old name to exist
     *
     * @return mixed
     */
    protected function getBelongsToManyCaller()
    {
        return $this->guessBelongsToManyRelation();
    }

    public static function getResizePresets()
    {
        return isset(static::$presets) ? static::$presets : [];
    }

    public function files()
    {
        return $this->morphToSortedMany(File::class, 'fileable');
    }

}