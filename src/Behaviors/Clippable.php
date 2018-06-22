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
        $presets = config('belt.clip.resize.models.' . static::class);

        if ($presets) {
            return $presets;
        }

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

    /**
     * @todo determine if it's okay to return null instead
     * @return Attachment
     */
    public function getImageAttribute()
    {
        foreach ($this->attachments as $attachment) {
            if ($attachment->isImage) {
                return $attachment;
            }
        }

        //return new Attachment();
    }

    /**
     * @return Attachment
     */
    public function getImagesAttribute()
    {
        $collection = collect();

        foreach ($this->attachments as $attachment) {
            if ($attachment->isImage) {
                $collection->push($attachment);
            }
        }

        return $collection;
    }

    /**
     * @param Attachment $attachment
     * @return $this
     */
    public function attachAttachment(Attachment $attachment)
    {
        try {
            if (!$this->attachments->contains($attachment->id)) {
                $this->attachments()->attach($attachment->id);
            }
        } catch (\Exception $e) {

        }

        $attachment->touch();

        return $this;
    }
}