<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Storage\File\File;
use Ohio\Storage\File\Http\Requests\StoreFile;
use Ohio\Storage\File\Http\Requests\PaginateFiles;
use Ohio\Storage\File\Http\Requests\UpdateFile;
use Ohio\Storage\File\Http\Controllers\Api\FilesController;
use Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilesControllerTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::__construct
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::get
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::show
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::destroy
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::update
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::store
     * @covers \Ohio\Storage\File\Http\Controllers\Api\FilesController::index
     */
    public function test()
    {

        $file1 = factory(File::class)->make();

        $qbMock = $this->getPaginateQBMock(new PaginateFiles(), [$file1]);

        $fileRepository = m::mock(File::class);
        $fileRepository->shouldReceive('find')->with(1)->andReturn($file1);
        $fileRepository->shouldReceive('find')->with(999)->andReturn(null);
        $fileRepository->shouldReceive('create')->andReturn($file1);
        $fileRepository->shouldReceive('query')->andReturn($qbMock);

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
        $response = $controller->store(new StoreFile(['name' => 'test']));
        $this->assertInstanceOf(JsonResponse::class, $response);

        # index
        $response = $controller->index(new PaginateFiles());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($file1->name, $response->getData()->data[0]->name);

    }

}