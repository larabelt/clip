<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Exceptions\ApiException;
use Belt\Core\Helpers\MorphHelper;
use Belt\Storage\File;
use Belt\Storage\Http\Requests;
use Belt\Storage\Http\Controllers\Api\FileablesController;
use Belt\Storage\Behaviors\Fileable;
use Illuminate\Database\Eloquent\Model;

class FileablesControllerTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::__construct
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::file
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::fileable
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::show
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::destroy
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::store
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::update
     * @covers \Belt\Storage\Http\Controllers\Api\FileablesController::index
     */
    public function test()
    {
        $this->actAsSuper();

        // mock page
        $page1 = new FileablesControllerTestStub();
        $page1->id = 1;

        // mock files
        File::unguard();
        $file1 = factory(File::class)->make();
        $file1->id = 1;
        $file2 = factory(File::class)->make();
        $file2->id = 2;
        $page1->files = new \Illuminate\Database\Eloquent\Collection();
        $page1->files->add($file1);

        // mocked dependencies
        $nullQB = $this->getQBMock();
        $nullQB->shouldReceive('first')->andReturn(null);
        $file1QB = $this->getQBMock();
        $file1QB->shouldReceive('first')->andReturn($file1);
        $file2QB = $this->getQBMock();
        $file2QB->shouldReceive('first')->andReturn($file2);

        $filesQB = $this->getQBMock();
        $filesQB->shouldReceive('where')->with('files.id', 999)->andReturn($nullQB);
        $filesQB->shouldReceive('where')->with('files.id', 1)->andReturn($file1QB);
        $filesQB->shouldReceive('where')->with('files.id', 2)->andReturn($file2QB);
        $filesQB->shouldReceive('filed')->with('pages', 1)->andReturn($filesQB);

        $fileRepo = m::mock(File::class);
        $fileRepo->shouldReceive('with')->andReturn($filesQB);

        $morphHelper = m::mock(MorphHelper::class);
        $morphHelper->shouldReceive('morph')->with('pages', 1)->andReturn($page1);
        $morphHelper->shouldReceive('morph')->with('pages', 999)->andReturn(null);

        # construct
        $controller = new FileablesController($fileRepo, $morphHelper);
        $this->assertEquals($fileRepo, $controller->files);
        $this->assertEquals($morphHelper, $controller->morphHelper);

        # file
        $file = $controller->file(1);
        $this->assertEquals($file1->name, $file->name);
        $file = $controller->file(1, $page1);
        $this->assertEquals($file1->name, $file->name);
        try {
            $controller->file(999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # fileable
        $page = $controller->fileable('pages', 1);
        $this->assertEquals($page1->name, $page->name);
        try {
            $controller->fileable('pages', 999);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }

        # show
        $response = $controller->show('pages', 1, 1);
        $this->assertEquals(200, $response->getStatusCode());

        # attach file
        $response = $controller->store(new Requests\AttachFile(['id' => 2]), 'pages', 1);
        $this->assertEquals(201, $response->getStatusCode());
        try {
            // file already attached
            $controller->store(new Requests\AttachFile(['id' => 1]), 'pages', 1);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(422, $e->getStatusCode());
        }

        # detach file
        $response = $controller->destroy('pages', 1, 1);
        $this->assertEquals(204, $response->getStatusCode());
        try {
            // file already not attached
            $controller->destroy('pages', 1, 2);
            $this->exceptionNotThrown();
        } catch (ApiException $e) {
            $this->assertEquals(422, $e->getStatusCode());
        }

        # update
        $response = $controller->update(new Requests\UpdateFileable(), 'pages', 1, 1);
        $this->assertEquals(200, $response->getStatusCode());

        # index
        $paginatorMock = $this->getPaginatorMock();
        $paginatorMock->shouldReceive('toArray')->andReturn([]);
        $controller = m::mock(FileablesController::class . '[paginator]', [$fileRepo, $morphHelper]);
        $controller->shouldReceive('paginator')->andReturn($paginatorMock);
        $response = $controller->index(new Requests\PaginateFileables(), 'pages', 1);
        $this->assertEquals(200, $response->getStatusCode());
    }

}

class FileablesControllerTestStub extends Model
{
    protected $guarded = [];

    use Fileable;

    public function getMorphClass()
    {
        return 'pages';
    }
}