<?php

namespace Belt\Clip\Http\Controllers\Web;

use Cache;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Controllers\BaseController;
use Belt\Clip\Attachment;
use Illuminate\Http\Request;

/**
 * Class ClippablesController
 * @package Belt\Clip\Http\Controllers\Api
 */
class ClippablesController extends ApiController
{

    /**
     * @var Attachment
     */
    public $attachments;

    /**
     * ClippablesController constructor.
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachments = $attachment;
    }

    /**
     * @param Request $request
     * @param $clippable_type
     * @param $clippable_id
     * @return mixed
     */
    public function show(Request $request, $clippable_type, $clippable_id)
    {
        $position = $request->segment(4) ?: 1;

        $field = $request->segment(5) ?: 'src';

        $key = sprintf('attachment:%s:%s:%s:%s', $clippable_type, $clippable_id, $position, $field);

        if ($value = Cache::get($key)) {
            return $value;
        }

        $attachment = $this->attachments
            ->join('clippables', 'clippables.attachment_id', '=', 'attachments.id')
            ->where('clippables.clippable_type', $clippable_type)
            ->where('clippables.clippable_id', $clippable_id)
            ->where('clippables.position', $position)
            ->first(['attachments.*']);

        if ($attachment && $value = $attachment->$field) {
            Cache::put($key, $value, 3600);
            return $value;
        }

        return response()->json(null, 404);
    }

}
