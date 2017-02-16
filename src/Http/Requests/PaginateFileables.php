<?php
namespace Belt\Clip\Http\Requests;

use Belt\Clip\File;
use Illuminate\Database\Eloquent\Builder;

class PaginateFileables extends PaginateFiles
{
    public $perPage = 5;

    public $orderBy = 'fileables.position';

//    /**
//     * @var File
//     */
//    public $files;
//
//    public function files()
//    {
//        return $this->files ?: $this->files = new File();
//    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show files associated with fileable
        if (!$this->get('not')) {
            $query->filed($this->get('fileable_type'), $this->get('fileable_id'));
        }

        # show files not associated with fileable
        if ($this->get('not')) {
            $query->notFiled($this->get('fileable_type'), $this->get('fileable_id'));
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function items(Builder $query)
    {
        return $query->get();
    }

}