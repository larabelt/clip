<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Storage\File\File;
use Illuminate\Database\Eloquent\Builder;

class PaginateFileables extends PaginateFiles
{
    public $perPage = 5;
    /**
     * @var File
     */
    public $files;

    public function files()
    {
        return $this->files ?: $this->files = new File();
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show files associated with fileable
        if (!$this->get('not')) {
            $query->fileged($this->get('fileable_type'), $this->get('fileable_id'));
        }

        # show files not associated with fileable
        if ($this->get('not')) {
            $query->notFileged($this->get('fileable_type'), $this->get('fileable_id'));
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