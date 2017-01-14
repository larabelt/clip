<?php
namespace Ohio\Storage\File;

use Ohio\Core;
use Ohio\Core\Base\Behaviors\DeltaableTrait;
use Ohio\Storage;

use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{

    use DeltaableTrait;

    protected $deltaable = [
        'columns' => ['fileable_id', 'fileable_type']
    ];

    protected $table = 'fileables';

}