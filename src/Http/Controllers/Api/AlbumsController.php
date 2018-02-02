<?php

namespace Belt\Clip\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Clip\Http\Requests;
use Belt\Clip\Album;
use Illuminate\Http\Request;

class AlbumsController extends ApiController
{

    /**
     * @var Album
     */
    public $albums;

    /**
     * ApiController constructor.
     * @param Album $album
     */
    public function __construct(Album $album)
    {
        $this->albums = $album;
    }

    public function get($id)
    {
        return $this->albums->find($id) ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('view', Album::class);

        $request = Requests\PaginateAlbums::extend($request);

        $paginator = $this->paginator($this->albums->query(), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreAlbum $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreAlbum $request)
    {
        $this->authorize('create', Album::class);

        $input = $request->all();

        if ($source = $request->get('source')) {
            return response()->json($this->albums->copy($source), 201);
        }

        $album = $this->albums->create([
            'name' => $input['name'],
        ]);

        $this->set($album, $input, [
            'team_id',
            'attachment_id',
            'is_active',
            'is_searchable',
            'status',
            'slug',
            'intro',
            'body',
            'hours',
            'url',
            'email',
            'phone',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ]);

        $album->save();

        return response()->json($album, 201);
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
        $album = $this->get($id);

        $this->authorize('view', $album);

        return response()->json($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateAlbum $request
     * @param  string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateAlbum $request, $id)
    {
        $album = $this->get($id);

        $this->authorize('update', $album);

        $input = $request->all();

        $this->set($album, $input, [
            'team_id',
            'attachment_id',
            'is_active',
            'is_searchable',
            'status',
            'name',
            'slug',
            'intro',
            'body',
            'hours',
            'url',
            'email',
            'phone',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ]);

        $album->save();

        return response()->json($album);
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
        $album = $this->get($id);

        $this->authorize('delete', $album);

        $album->delete();

        return response()->json(null, 204);
    }
}
