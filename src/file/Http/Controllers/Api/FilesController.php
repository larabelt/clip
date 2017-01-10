<?php

namespace Ohio\Storage\File\Http\Controllers\Api;

use Ohio\Core\Base\Http\Controllers\ApiController;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Http\Requests;

class FilesController extends ApiController
{

    /**
     * @var File
     */
    public $files;

    /**
     * ApiController constructor.
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->files = $file;
    }

    public function get($id)
    {
        return $this->files->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateFiles $request)
    {
        $paginator = $this->paginator($this->files->query(), $request->reCapture());

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreFile $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreFile $request)
    {

        $input = $request->all();

        $file = $this->files->create([
            'name' => $input['name'],
        ]);

        $this->set($file, $input, [
            'slug',
            'body',
        ]);

        $file->save();

        return response()->json($file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = $this->get($id);

        return response()->json($file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateFile $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateFile $request, $id)
    {
        $file = $this->get($id);

        $input = $request->all();

        $this->set($file, $input, [
            'name',
            'slug',
            'body',
        ]);

        $file->save();

        return response()->json($file);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = $this->get($id);

        $file->delete();

        return response()->json(null, 204);
    }
}
