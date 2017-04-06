<?php

namespace Belt\Clip\Behaviors;

use DB;
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

    /**
     * purge related items in clippables table
     */
    public function purgeAttachments()
    {
        DB::connection($this->getConnectionName())
            ->table('clippables')
            ->where('clippable_id', $this->id)
            ->where('clippable_type', $this->getMorphClass())
            ->delete();
    }

    public function image()
    {
        return $this->morphToSortedMany(Attachment::class, 'clippable')
            ->withPivot('position')
            ->first();
    }
}