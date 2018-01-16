<?php
namespace Belt\Clip\Http\Requests;

use Belt;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateAlbums extends PaginateRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $modelClass = Belt\Clip\Album::class;

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
        Belt\Core\Pagination\InQueryModifier::class,
        Belt\Core\Pagination\TeamableQueryModifier::class,
        Belt\Glue\Pagination\TaggableQueryModifier::class,
    ];

}