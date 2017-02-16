<?php

namespace Belt\Storage\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Controllers\Behaviors\Positionable;
use Belt\Storage\File;
use Belt\Storage\Http\Requests;
use Belt\Core\Helpers\MorphHelper;

class FileablesController extends ApiController
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

    public function file($id, $fileable = null)
    {
        $qb = $this->files->with('resizes');

        if ($fileable) {
            $qb->filed($fileable->getMorphClass(), $fileable->id);
        }

        $file = $qb->where('files.id', $id)->first();

        return $file ?: $this->abort(404);
    }

    public function fileable($fileable_type, $fileable_id)
    {
        $fileable = $this->morphHelper->morph($fileable_type, $fileable_id);

        return $fileable ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateFileables $request, $fileable_type, $fileable_id)
    {

        $request->reCapture();

        $owner = $this->fileable($fileable_type, $fileable_id);

        $this->authorize('view', $owner);

        $request->merge([
            'fileable_id' => $owner->id,
            'fileable_type' => $owner->getMorphClass()
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
    public function store(Requests\AttachFile $request, $fileable_type, $fileable_id)
    {
        $owner = $this->fileable($fileable_type, $fileable_id);

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
     * @param  Requests\UpdateFileable $request
     * @param  string $fileable_type
     * @param  string $fileable_id
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateFileable $request, $fileable_type, $fileable_id, $id)
    {
        $owner = $this->fileable($fileable_type, $fileable_id);

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
    public function show($fileable_type, $fileable_id, $id)
    {
        $owner = $this->fileable($fileable_type, $fileable_id);

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
    public function destroy($fileable_type, $fileable_id, $id)
    {
        $owner = $this->fileable($fileable_type, $fileable_id);

        $this->authorize('update', $owner);

        if (!$owner->files->contains($id)) {
            $this->abort(422, ['id' => ['file not attached']]);
        }

        $owner->files()->detach($id);

        return response()->json(null, 204);
    }
}
