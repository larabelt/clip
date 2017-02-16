<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\PaginateRequest;

class PaginateAttachments extends PaginateRequest
{
    public $perPage = 10;

    public $orderBy = 'attachments.id';

    public $sortable = [
        'attachments.id',
        'attachments.name',
    ];

    public $searchable = [
        'attachments.name',
        'attachments.original_name',
        'attachments.title',
        'attachments.note',
        'attachments.credits',
        'attachments.alt',
    ];

}