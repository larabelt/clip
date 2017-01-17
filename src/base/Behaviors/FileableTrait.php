<?php
namespace Ohio\Storage\Base\Behaviors;

use Ohio\Storage\File\File;
use Rutorika\Sortable\MorphToSortedManyTrait;

trait FileableTrait
{

    use MorphToSortedManyTrait;

    public function files()
    {
        return $this->morphToSortedMany(File::class, 'fileable');
    }

}