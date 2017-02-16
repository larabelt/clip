<?php
namespace Belt\Clip;

use Illuminate\Database\Eloquent\Model;

class Resize extends Model implements AttachmentInterface
{
    use AttachmentTrait;

    protected $table = 'attachment_resizes';

    protected $morphClass = 'attachment_resizes';

    protected $fillable = ['driver', 'name'];

    protected $appends = ['src', 'secure', 'rel_path', 'preset'];

    /**
     * Get owning model
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function getPresetAttribute()
    {
        return sprintf('%s:%s', $this->width, $this->height);
    }

}