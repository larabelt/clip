<?php

namespace Ohio\Storage\File\Http\Controllers\Api;

use Ohio\Core\Base\Http\Controllers\ApiController;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Fileable;
use Ohio\Storage\File\Http\Requests;
use Ohio\Core\Base\Helper\MorphHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FileablesController extends ApiController
{

    /**
     * @var File
     */
    public $files;

    /**
     * @var Fileable
     */
    public $fileables;

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    public function __construct(File $file, Fileable $fileable, MorphHelper $morphHelper)
    {
        $this->files = $file;
        $this->fileables = $fileable;
        $this->morphHelper = $morphHelper;
    }

    public function file($id, $fileable = null)
    {
        $qb = $this->files->query();

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

        $fileable = $this->fileable($fileable_type, $fileable_id);

        $request->merge([
            'fileable_id' => $fileable->id,
            'fileable_type' => $fileable->getMorphClass()
        ]);

        $paginator = $this->paginator($this->files->query(), $request);

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

        $id = $request->get('id');

        if ($owner->files->contains($id)) {
            $this->abort(422, ['id' => ['file already attached']]);
        }

        $file = $this->file($id);

        $count = $this->fileables->deltaable([
            'fileable_type' => $fileable_type,
            'fileable_id' => $fileable_id,
        ])->count();

        $owner->files()->attach($id, ['delta' => $count + 1.1]);

        Fileable::deltaableSort([
            'fileable_type' => $fileable_type,
            'fileable_id' => $fileable_id,
        ])->count();



        return response()->json($this->file($id), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  string $fileable_type
     * @param  string $fileable_id
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fileable_type, $fileable_id, $id)
    {
        $fileable = $this->fileable($fileable_type, $fileable_id);

        $file = $this->file($id, $fileable);

        // make delta last on attach
        // resort when detached...
        // resort when delta is updated: integer or 'inc' or 'dec', 1, or 'last'

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
        $fileable = $this->fileable($fileable_type, $fileable_id);

        $file = $this->file($id, $fileable);

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
        $fileable = $this->fileable($fileable_type, $fileable_id);

        if (!$fileable->files->contains($id)) {
            $this->abort(422, ['id' => ['file not attached']]);
        }

        $fileable->files()->detach($id);

        return response()->json(null, 204);
    }
}
