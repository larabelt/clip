<?php

namespace Belt\Clip;

use Belt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 * @package Belt\Clip
 */
class Album extends Model implements
    Belt\Core\Behaviors\SluggableInterface,
    Belt\Clip\Behaviors\ClippableInterface,
    Belt\Content\Behaviors\IncludesContentInterface,
    Belt\Content\Behaviors\SectionableInterface
{
    use Belt\Core\Behaviors\HasSortableTrait;
    use Belt\Core\Behaviors\Sluggable;
    use Belt\Clip\Behaviors\Clippable;
    use Belt\Content\Behaviors\IncludesContent;
    use Belt\Content\Behaviors\Sectionable;

    /**
     * @var string
     */
    protected $morphClass = 'albums';

    /**
     * @var string
     */
    protected $table = 'albums';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var array
     */
    protected $appends = ['image'];

    /**
     * @var array
     */
    public static $presets = [
        [100, 100, 'fit'],
        [222, 222, 'resize'],
        [333, 333, 'resize'],
        [500, 500, 'resize'],
    ];

}