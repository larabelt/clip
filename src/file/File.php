<?php
namespace Ohio\Storage\File;

use Ohio\Core;
use Ohio\Storage;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Core\Base\Behaviors\SluggableTrait;
    use Storage\Base\Behaviors\StorageTrait;

    protected $morphClass = 'storage/file';

    protected $table = 'files';

    protected $fillable = ['name'];

    /**
     * Return files associated with fileable
     *
     * @param $query
     * @param $fileable_type
     * @param $fileable_id
     * @return mixed
     */
    public function scopeFileged($query, $fileable_type, $fileable_id)
    {
        $query->select(['files.*']);
        $query->join('fileables', 'fileables.file_id', '=', 'files.id');
        $query->where('fileables.fileable_type', $fileable_type);
        $query->where('fileables.fileable_id', $fileable_id);

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
    public function scopeNotFileged($query, $fileable_type, $fileable_id)
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