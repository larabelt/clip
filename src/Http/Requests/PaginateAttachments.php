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
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Clip\Attachment::class;

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
        'attachments.created_at',
        'attachments.updated_at',
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
        Belt\Core\Pagination\InQueryModifier::class,
        Belt\Core\Pagination\TeamableQueryModifier::class,
        Belt\Content\Pagination\TermableQueryModifier::class,
    ];

}