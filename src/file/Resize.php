<?php
namespace Ohio\Storage\File;

use Illuminate\Database\Eloquent\Model;

class Resize extends Model
{

    protected $table = 'file_resizes';

    protected $fillable = ['disk'];

    protected $appends = ['src', 'secure'];

    /**
     * Get owning model
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

}