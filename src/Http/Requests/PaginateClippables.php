<?php
namespace Belt\Clip\Http\Requests;

use Belt\Clip\File;
use Illuminate\Database\Eloquent\Builder;

class PaginateClippables extends PaginateFiles
{
    public $perPage = 5;

    public $orderBy = 'clippables.position';

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
        # show files associated with clippable
        if (!$this->get('not')) {
            $query->filed($this->get('clippable_type'), $this->get('clippable_id'));
        }

        # show files not associated with clippable
        if ($this->get('not')) {
            $query->notFiled($this->get('clippable_type'), $this->get('clippable_id'));
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