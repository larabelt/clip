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
    Belt\Core\Behaviors\TeamableInterface,
    Belt\Core\Behaviors\TypeInterface,
    Belt\Clip\Behaviors\ClippableInterface,
    Belt\Content\Behaviors\IncludesContentInterface,
    Belt\Content\Behaviors\SectionableInterface,
    Belt\Glue\Behaviors\TaggableInterface
{
    use Belt\Core\Behaviors\HasSortableTrait;
    use Belt\Core\Behaviors\Sluggable;
    use Belt\Core\Behaviors\Teamable;
    use Belt\Core\Behaviors\TypeTrait;
    use Belt\Clip\Behaviors\Clippable;
    use Belt\Content\Behaviors\IncludesContent;
    use Belt\Content\Behaviors\Sectionable;
    use Belt\Glue\Behaviors\Taggable;

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
    protected $appends = ['image', 'morph_class'];

    /**
     * @var array
     */
    public static $presets = [
        [100, 100, 'fit'],
        [222, 222, 'resize'],
        [333, 333, 'resize'],
        [500, 500, 'resize'],
    ];

    /**
     * @param $album
     * @return Model
     */
    public static function copy($album)
    {
        $album = $album instanceof Album ? $album : self::sluggish($album)->first();

        $clone = $album->replicate();
        $clone->slug .= '-' . strtotime('now');
        $clone->push();

        foreach ($album->attachments as $attachment) {
            $clone->attachments()->attach($attachment);
        }

        foreach ($album->tags as $tag) {
            $clone->tags()->attach($tag);
        }

        return $clone;
    }

}