<?php

namespace Belt\Clip\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Clip\Adapters\AdapterFactory;
use Belt\Clip\File;
use Belt\Clip\Http\Requests;
use Belt\Clip\Adapters\Ad;
use Belt\Clip\Adapters\BaseAdapter;

class FilesController extends ApiController
{

    /**
     * @var File
     */
    public $files;

    public function adapter($driver)
    {
        return AdapterFactory::up($driver);
    }

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
        return $this->files->with('resizes')->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\PaginateFiles $request)
    {
        $this->authorize('index', File::class);

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
        $this->authorize('create', File::class);

        $driver = $request->get('driver') ?: 'default';
        $path = $request->get('path') ?: '';

        $adapter = $this->adapter($driver);

        $data = $adapter->upload($path, $request->file('file'));

        $input = array_merge($request->all(), $data);

        $file = $this->files->createFromUpload($input);

        $this->set($file, $input, [
            'is_public',
            'title',
            'note',
            'credits',
            'alt',
            'url',
        ]);

        $file->save();

        return response()->json($file, 201);
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

        $this->authorize('view', $file);

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

        $this->authorize('update', $file);

        $input = $request->all();

        $this->set($file, $input, [
            'is_public',
            'title',
            'note',
            'credits',
            'alt',
            'url',
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

        $this->authorize('delete', $file);

        $file->delete();

        return response()->json(null, 204);
    }
}
