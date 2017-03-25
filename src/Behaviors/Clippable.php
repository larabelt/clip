<?php
namespace Belt\Clip\Behaviors;

use Belt\Clip\Attachment;

/**
 * Class Clippable
 * @package Belt\Clip\Behaviors
 */
trait Clippable
{

    /**
     * @return array
     */
    public static function getResizePresets()
    {
        return isset(static::$presets) ? static::$presets : [];
    }

    /**
     * @todo need 2 classes for single attachments vs collections
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    /**
     * @return \Rutorika\Sortable\BelongsToSortedMany
     */
    public function attachments()
    {
        return $this->morphToSortedMany(Attachment::class, 'clippable')->withPivot('position');
    }

}