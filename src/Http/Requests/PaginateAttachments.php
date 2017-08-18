<?php
namespace Belt\Clip\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

/**
 * Class PaginateAttachments
 * @package Belt\Clip\Http\Requests
 */
class PaginateAttachments extends PaginateRequest
{
    /**
     * @var int
     */
    public $perPage = 10;

    /**
     * @var string
     */
    public $orderBy = 'attachments.id';

    /**
     * @var array
     */
    public $sortable = [
        'attachments.id',
        'attachments.name',
    ];

    /**
     * @var array
     */
    public $searchable = [
        'attachments.id',
        'attachments.name',
        'attachments.original_name',
        'attachments.title',
        'attachments.note',
        'attachments.credits',
        'attachments.alt',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [
        Belt\Glue\Pagination\TaggableQueryModifier::class,
        Belt\Core\Pagination\TeamableQueryModifier::class
    ];

}