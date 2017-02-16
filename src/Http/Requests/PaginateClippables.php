<?php
namespace Belt\Clip\Http\Requests;

use Belt\Clip\Attachment;
use Illuminate\Database\Eloquent\Builder;

class PaginateClippables extends PaginateAttachments
{
    public $perPage = 5;

    public $orderBy = 'clippables.position';

    /**
     * @inheritdoc
     */
    public function modifyQuery(Builder $query)
    {
        # show files associated with clippable
        if (!$this->get('not')) {
            $query->attached($this->get('clippable_type'), $this->get('clippable_id'));
        }

        # show files not associated with clippable
        if ($this->get('not')) {
            $query->notAttached($this->get('clippable_type'), $this->get('clippable_id'));
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