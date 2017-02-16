<?php
namespace Belt\Clip\Behaviors;

use Belt\Clip\Attachment;
use Rutorika\Sortable\MorphToSortedManyTrait;

trait Clippable
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

    public function attachments()
    {
        return $this->morphToSortedMany(Attachment::class, 'clippable');
    }

}