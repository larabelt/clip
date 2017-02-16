<?php
namespace Belt\Clip;

use Belt;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model implements AttachmentInterface
{
    use AttachmentTrait;

    protected $morphClass = 'attachments';

    protected $table = 'attachments';

    protected $fillable = ['driver', 'name'];

    protected $appends = ['src', 'secure', 'rel_path', 'readable_size'];

    public function resizes()
    {
        return $this->hasMany(Resize::class);
    }

    public function sized($w, $h)
    {
        return $this->__sized($w, $h) ?: $this;
    }

    public function __sized($w, $h)
    {
        $preset = sprintf('%s:%s', $w, $h);

        $resized = $this->resizes->where('preset', $preset)->first();

        return $resized;
    }

    /**
     * Return attachments associated with clippable
     *
     * @param $query
     * @param $clippable_type
     * @param $clippable_id
     * @return mixed
     */
    public function scopeAttached($query, $clippable_type, $clippable_id)
    {
        $query->select(['attachments.*']);
        $query->join('clippables', 'clippables.attachment_id', '=', 'attachments.id');
        $query->where('clippables.clippable_type', $clippable_type);
        $query->where('clippables.clippable_id', $clippable_id);
        $query->orderBy('clippables.position');

        return $query;
    }

    /**
     * Return attachments not associated with clippable
     *
     * @param $query
     * @param $clippable_type
     * @param $clippable_id
     * @return mixed
     */
    public function scopeNotAttached($query, $clippable_type, $clippable_id)
    {
        $query->select(['attachments.*']);
        $query->leftJoin('clippables', function ($subQB) use ($clippable_type, $clippable_id) {
            $subQB->on('clippables.attachment_id', '=', 'attachments.id');
            $subQB->where('clippables.clippable_id', $clippable_id);
            $subQB->where('clippables.clippable_type', $clippable_type);
        });
        $query->whereNull('clippables.id');

        return $query;
    }

}