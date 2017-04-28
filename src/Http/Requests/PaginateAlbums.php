<?php
namespace Belt\Clip\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateAlbums extends PaginateRequest
{
    public $perAlbum = 10;

    public $orderBy = 'albums.id';

    public $sortable = [
        'albums.id',
        'albums.name',
    ];

    public $searchable = [
        'albums.name',
    ];

    /**
     * @var Belt\Core\Pagination\PaginationQueryModifier[]
     */
    public $queryModifiers = [
        Belt\Glue\Pagination\TaggableQueryModifier::class,
    ];

}