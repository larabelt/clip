<?php

use Mockery as m;
use Belt\Core\Testing;

use Belt\Clip\File;
use Belt\Clip\Http\Requests\StoreFile;
use Belt\Clip\Http\Requests\PaginateFiles;
use Belt\Clip\Http\Requests\UpdateFile;
use Belt\Clip\Http\Controllers\Api\FilesController;
use Belt\Clip\Adapters\AdapterFactory;
use Belt\Clip\Adapters\BaseAdapter;
use Belt\Core\Http\Exceptions\ApiNotFoundHttpException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class FilesControllerTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::__construct
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::get
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::show
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::destroy
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::update
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::store
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::index
     * @covers \Belt\Clip\Http\Controllers\Api\FilesController::adapter
     */
    public function test()
    {
        $this->actAsSuper();

        $file1 = factory(File::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateFiles(), [$file1]);

        $fileRepository = m::mock(File::class);
        $fileRepository->shouldReceive('find')->with(1)->andReturn($file1);
        $fileRepository->shouldReceive('find')->with(999)->andReturn(null);
        $fileRepository->shouldReceive('with')->andReturnSelf();
        $fileRepository->shouldReceive('query')->andReturn($qbMock);
        $fileRepository->shouldReceive('createFromUpload')->andReturn($file1);

        # construct
        $controller = new FilesController($fileRepository);
        $this->assertEquals($fileRepository, $controller->files);

        # get existing file
        $file = $controller->get(1);
        $this->assertEquals($file1->name, $file->name);

        # get file that doesn't exist
        try {
            $controller->get(999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ApiNotFoundHttpException::class, $e);
        }

        # show file
        $response = $controller->show(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData();
        $this->assertEquals($file1->name, $data->name);

        # destroy file
        $response = $controller->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());

        # update file
        $response = $controller->update(new UpdateFile(), 1);
        $this->assertInstanceOf(JsonResponse::class, $response);

        # create file
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('upload')->andReturn(['name' => 'test.jpg']);
        $adapter->shouldReceive('create')->andReturn(factory(File::class)->make());

        AdapterFactory::$adapters['FilesControllerTest'] = $adapter;
        $response = $controller->store(new StoreFile(
            [],
            ['disk' => 'FilesControllerTest'],
            [],
            [],
            ['file' => new UploadedFile(__DIR__ . '/../../../testing/test.jpg', 'test.jpg')]));
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new PaginateFiles());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($file1->name, $response->getData()->data[0]->name);

        # adapter
        $this->assertEquals($adapter, $controller->adapter('FilesControllerTest'));

    }

}