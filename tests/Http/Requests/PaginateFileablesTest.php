<?php
use Mockery as m;
use Ohio\Core\Testing;

use Ohio\Storage\File;
use Ohio\Storage\Http\Requests\PaginateFileables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateFileablesTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Http\Requests\PaginateFileables::modifyQuery
     * @covers \Ohio\Storage\Http\Requests\PaginateFileables::items
     */
    public function test()
    {
        $file1 = new File();
        $file1->id = 1;
        $file1->name = 'file 1';

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('filed')->once()->with('pages', 1);
        $qbMock->shouldReceive('notFiled')->once()->with('pages', 1);
        $qbMock->shouldReceive('get')->once()->andReturn(new Collection([$file1]));

        # modifyQuery
        $paginateRequest = new PaginateFileables(['fileable_id' => 1, 'fileable_type' => 'pages']);
        $paginateRequest->modifyQuery($qbMock);
        $paginateRequest->merge(['not' => true]);
        $paginateRequest->modifyQuery($qbMock);

//        # files
//        s($paginateRequest->files);
//        $this->assertNull($paginateRequest->files);
//        $paginateRequest->files();
//        $this->assertInstanceOf(File::class, $paginateRequest->files);

        # items
        $paginateRequest->items($qbMock);
    }

}