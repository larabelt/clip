<?php
namespace Ohio\Storage;

use Ohio;
use Illuminate\Database\Eloquent\Model;

class File extends Model implements FileInterface
{
    use FileTrait;

    protected $morphClass = 'files';

    protected $table = 'files';

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
     * Return files associated with fileable
     *
     * @param $query
     * @param $fileable_type
     * @param $fileable_id
     * @return mixed
     */
    public function scopeFiled($query, $fileable_type, $fileable_id)
    {
        $query->select(['files.*']);
        $query->join('fileables', 'fileables.file_id', '=', 'files.id');
        $query->where('fileables.fileable_type', $fileable_type);
        $query->where('fileables.fileable_id', $fileable_id);
        $query->orderBy('fileables.position');

        return $query;
    }

    /**
     * Return files not associated with fileable
     *
     * @param $query
     * @param $fileable_type
     * @param $fileable_id
     * @return mixed
     */
    public function scopeNotFiled($query, $fileable_type, $fileable_id)
    {
        $query->select(['files.*']);
        $query->leftJoin('fileables', function ($subQB) use ($fileable_type, $fileable_id) {
            $subQB->on('fileables.file_id', '=', 'files.id');
            $subQB->where('fileables.fileable_id', $fileable_id);
            $subQB->where('fileables.fileable_type', $fileable_type);
        });
        $query->whereNull('fileables.id');

        return $query;
    }

}