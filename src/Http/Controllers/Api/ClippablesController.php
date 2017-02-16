<?php

namespace Belt\Clip\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Controllers\Behaviors\Positionable;
use Belt\Clip\File;
use Belt\Clip\Http\Requests;
use Belt\Core\Helpers\MorphHelper;

class ClippablesController extends ApiController
{

    use Positionable;

    /**
     * @var File
     */
    public $files;

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    public function __construct(File $file, MorphHelper $morphHelper)
    {
        $this->files = $file;
        $this->morphHelper = $morphHelper;
    }

    public function file($id, $clippable = null)
    {
        $qb = $this->files->with('resizes');

        if ($clippable) {
            $qb->filed($clippable->getMorphClass(), $clippable->id);
        }

        $file = $qb->where('files.id', $id)->first();

        return $file ?: $this->abort(404);
    }

    public function clippable($clippable_type, $clippable_id)
    {
        $clippable = $this->morphHelper->morph($clippable_type, $clippable_id);

        return $clippable ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateClippables $request, $clippable_type, $clippable_id)
    {

        $request->reCapture();

        $owner = $this->clippable($clippable_type, $clippable_id);

        $this->authorize('view', $owner);

        $request->merge([
            'clippable_id' => $owner->id,
            'clippable_type' => $owner->getMorphClass()
        ]);

        $paginator = $this->paginator($this->files->with('resizes'), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\AttachFile $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AttachFile $request, $clippable_type, $clippable_id)
    {
        $owner = $this->clippable($clippable_type, $clippable_id);

        $this->authorize('update', $owner);

        $id = $request->get('id');

        $file = $this->file($id);

        if ($owner->files->contains($id)) {
            $this->abort(422, ['id' => ['file already attached']]);
        }

        $owner->files()->attach($id);

        return response()->json($file, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateClippable $request
     * @param  string $clippable_type
     * @param  string $clippable_id
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateClippable $request, $clippable_type, $clippable_id, $id)
    {
        $owner = $this->clippable($clippable_type, $clippable_id);

        $this->authorize('update', $owner);

        $file = $this->file($id, $owner);

        $this->repositionEntity($request, $id, $owner->files, $owner->files());

        return response()->json($file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($clippable_type, $clippable_id, $id)
    {
        $owner = $this->clippable($clippable_type, $clippable_id);

        $this->authorize('view', $owner);

        $file = $this->file($id, $owner);

        return response()->json($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($clippable_type, $clippable_id, $id)
    {
        $owner = $this->clippable($clippable_type, $clippable_id);

        $this->authorize('update', $owner);

        if (!$owner->files->contains($id)) {
            $this->abort(422, ['id' => ['file not attached']]);
        }

        $owner->files()->detach($id);

        return response()->json(null, 204);
    }
}
