<?php
namespace Ohio\Storage\File;

use Illuminate\Database\Eloquent\Model;

class Resize extends Model implements FileInterface
{
    use FileTrait;

    protected $table = 'file_resizes';

    protected $morphClass = 'file_resizes';

    protected $fillable = ['disk', 'name'];

    protected $appends = ['src', 'secure'];

    /**
     * Get owning model
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

}