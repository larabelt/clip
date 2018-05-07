<?php

namespace Belt\Clip\Http\Controllers\Api;

use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Clip\Adapters\AdapterFactory;
use Belt\Clip\Attachment;
use Belt\Clip\Resize;
use Belt\Clip\Http\Requests;
use Belt\Clip\Adapters\BaseAdapter;
use Illuminate\Http\Request;

/**
 * Class AttachmentsController
 * @package Belt\Clip\Http\Controllers\Api
 */
class ResizesController extends ApiController
{

    /**
     * @var Resize
     */
    public $resizes;

    /**
     * @param $driver
     * @return BaseAdapter
     */
    public function adapter($driver)
    {
        return AdapterFactory::up($driver);
    }

    /**
     * ApiController constructor.
     * @param Resize $resize
     */
    public function __construct(Resize $resize)
    {
        $this->resizes = $resize;
    }

    /**
     * @param Attachment $attachment
     * @param Resize $resize
     */
    public function contains(Attachment $attachment, Resize $resize)
    {
        if (!$attachment->resizes->contains($resize->id)) {
            $this->abort(404, 'resize does not belong to attachment');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Attachment $attachment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Attachment $attachment)
    {

        $this->authorize(['view', 'create', 'update', 'delete'], $attachment);

        $request = PaginateRequest::extend($request);

        $paginator = $this->paginator($this->resizes->where('attachment_id', $attachment->id), $request);

        return response()->json($paginator->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\StoreResize $request
     * @param Attachment $attachment
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreResize $request, Attachment $attachment)
    {
        $this->authorize('update', $attachment);

        # variables
        $driver = $request->get('driver', null);
        $path = $request->get('path') ?: '';
        $mode = $request->get('mode') ?: 'default';

        # upload
        $adapter = $this->adapter($driver);
        $data = $adapter->upload($path, $request->file('file'));

        # set attributes
        $input = array_merge($request->all(), $data);
        $attributes = $this->resizes->setAttributesFromUpload($data);
        $attributes['attachment_id'] = $attachment->id;
        $attributes['mode'] = $mode;

        # save
        Resize::unguard();
        $resize = $this->resizes->create($attributes);
        $this->set($resize, $input, [
            'nickname',
        ]);
        $resize->save();

        return response()->json($resize, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Attachment $attachment
     * @param Resize $resize
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment, Resize $resize)
    {
        $this->authorize(['view', 'create', 'update', 'delete'], $attachment);

        $this->contains($attachment, $resize);

        return response()->json($resize);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Attachment $attachment
     * @param Resize $resize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment, Resize $resize)
    {
        $this->authorize('update', $attachment);

        $this->contains($attachment, $resize);

        $input = $request->all();

        $this->set($resize, $input, [
            'nickname',
        ]);

        $resize->save();

        return response()->json($resize);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Attachment $attachment
     * @param Resize $resize
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment, Resize $resize)
    {
        $this->authorize('update', $attachment);

        $this->contains($attachment, $resize);

        $resize->delete();

        return response()->json(null, 204);
    }
}
