<?php

namespace Belt\Clip\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Controllers\Behaviors\Positionable;
use Belt\Clip\Attachment;
use Belt\Clip\Http\Requests;
use Belt\Core\Helpers\MorphHelper;

/**
 * Class AttachablesController
 * @package Belt\Clip\Http\Controllers\Api
 */
class AttachablesController extends ApiController
{

    use Positionable;

    /**
     * @var Attachment
     */
    public $attachment;

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    /**
     * ClippablesController constructor.
     * @param Attachment $attachment
     * @param MorphHelper $morphHelper
     */
    public function __construct(Attachment $attachment, MorphHelper $morphHelper)
    {
        $this->attachment = $attachment;
        $this->morphHelper = $morphHelper;
    }

    /**
     * @param $id
     */
    public function attachment($id)
    {
        $qb = $this->attachment->with('resizes');

        $attachment = $qb->where('attachments.id', $id)->first();

        return $attachment ?: $this->abort(404);
    }

    /**
     * @param $attachable_type
     * @param $attachable_id
     */
    public function attachable($attachable_type, $attachable_id)
    {
        $attachable = $this->morphHelper->morph($attachable_type, $attachable_id);

        return $attachable ?: $this->abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\AttachAttachment $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AttachAttachment $request, $attachable_type, $attachable_id)
    {
        $owner = $this->attachable($attachable_type, $attachable_id);

        $this->authorize('update', $owner);

        $attachment = $this->associate($attachable_type, $attachable_id, $request->get('id'));

        $this->itemEvent('attachments.attached', $owner);

        return response()->json($attachment, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\AttachAttachment $request
     * @param  string $attachable_type
     * @param  string $attachable_id
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\AttachAttachment $request, $attachable_type, $attachable_id, $id = null)
    {
        $id = $request->get('id') ?: $id;

        $owner = $this->attachable($attachable_type, $attachable_id);

        $attachment = $this->associate($attachable_type, $attachable_id, $id);

        $this->itemEvent('attachments.updated', $owner);

        return response()->json($attachment);
    }

    private function associate($attachable_type, $attachable_id, $id)
    {
        $owner = $this->attachable($attachable_type, $attachable_id);

        $this->authorize('update', $owner);

        $attachment = $this->attachment($id);

        $owner->attachment()->associate($attachment);

        $owner->save();

        $this->itemEvent('updated', $owner);

        return $attachment;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($attachable_type, $attachable_id)
    {
        $owner = $this->attachable($attachable_type, $attachable_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $owner);

        $attachment = $this->attachment($owner->attachment_id);

        return response()->json($attachment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($attachable_type, $attachable_id)
    {
        $owner = $this->attachable($attachable_type, $attachable_id);

        $this->authorize('update', $owner);

        if (!$owner->attachment_id) {
            $this->abort(422, ['id' => ['no attachment to delete']]);
        }

        $owner->attachment_id = null;
        $owner->save();

        $this->itemEvent('attachments.detached', $owner);

        return response()->json(null, 204);
    }
}
