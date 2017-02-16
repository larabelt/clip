<?php
namespace Belt\Clip;

use Belt;
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
     * Return files associated with clippable
     *
     * @param $query
     * @param $clippable_type
     * @param $clippable_id
     * @return mixed
     */
    public function scopeFiled($query, $clippable_type, $clippable_id)
    {
        $query->select(['files.*']);
        $query->join('clippables', 'clippables.file_id', '=', 'files.id');
        $query->where('clippables.clippable_type', $clippable_type);
        $query->where('clippables.clippable_id', $clippable_id);
        $query->orderBy('clippables.position');

        return $query;
    }

    /**
     * Return files not associated with clippable
     *
     * @param $query
     * @param $clippable_type
     * @param $clippable_id
     * @return mixed
     */
    public function scopeNotFiled($query, $clippable_type, $clippable_id)
    {
        $query->select(['files.*']);
        $query->leftJoin('clippables', function ($subQB) use ($clippable_type, $clippable_id) {
            $subQB->on('clippables.file_id', '=', 'files.id');
            $subQB->where('clippables.clippable_id', $clippable_id);
            $subQB->where('clippables.clippable_type', $clippable_type);
        });
        $query->whereNull('clippables.id');

        return $query;
    }

}