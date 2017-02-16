<?php
namespace Belt\Storage\Http\Requests;

use Belt\Core\Http\Requests\PaginateRequest;

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
        'files.original_name',
        'files.title',
        'files.note',
        'files.credits',
        'files.alt',
    ];

}