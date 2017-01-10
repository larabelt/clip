<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Core\Base\Http\Requests\PaginateRequest;

class PaginateFiles extends PaginateRequest
{
    public $perFile = 10;

    public $orderBy = 'files.id';

    public $sortable = [
        'files.id',
        'files.name',
    ];

    public $searchable = [
        'files.name',
    ];

}