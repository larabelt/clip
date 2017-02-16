<?php
namespace Belt\Clip;

use Illuminate\Database\Eloquent\Model;

class Resize extends Model implements FileInterface
{
    use FileTrait;

    protected $table = 'file_resizes';

    protected $morphClass = 'file_resizes';

    protected $fillable = ['driver', 'name'];

    protected $appends = ['src', 'secure', 'rel_path', 'preset'];

    /**
     * Get owning model
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getPresetAttribute()
    {
        return sprintf('%s:%s', $this->width, $this->height);
        //return sprintf('%s:%s:%s', $this->width, $this->height, substr($this->mode, 0, 1));
    }

}