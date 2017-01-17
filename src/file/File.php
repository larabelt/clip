<?php
namespace Ohio\Storage\File;

use Ohio\Core;
use Ohio\Storage;
use Ohio\Storage\File\Adapters\BaseAdapter;
use Ohio\Storage\File\Adapters\AdapterFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $morphClass = 'storage/file';

    protected $table = 'files';

    protected $fillable = ['disk', 'name'];

    protected $appends = ['src', 'secure'];

    /**
     * @var BaseAdapter
     */
    protected $adapter;

    public function adapter()
    {
        return $this->adapter ?: AdapterFactory::up($this->disk);
    }

    public function getSrcAttribute()
    {
        return $this->adapter()->src($this);
    }

    public function getSecureAttribute()
    {
        return $this->adapter()->secure($this);
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
        $query->orderby('fileables.position');

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