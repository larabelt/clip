<?php
use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Storage\Page\Page;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Http\Requests\PaginateFileables;
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
     * @covers \Ohio\Storage\File\Http\Requests\PaginateFileables::modifyQuery
     * @covers \Ohio\Storage\File\Http\Requests\PaginateFileables::files
     * @covers \Ohio\Storage\File\Http\Requests\PaginateFileables::items
     */
    public function test()
    {
        $page = new Page();
        $page->id = 1;
        $page->name = 'page';

        $file1 = new File();
        $file1->id = 1;
        $file1->name = 'file 1';

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('fileged')->once()->with('pages', 1);
        $qbMock->shouldReceive('notFileged')->once()->with('pages', 1);
        $qbMock->shouldReceive('get')->once()->andReturn(new Collection([$file1]));

        # modifyQuery
        $paginateRequest = new PaginateFileables(['fileable_id' => 1, 'fileable_type' => 'pages']);
        $paginateRequest->modifyQuery($qbMock);
        $paginateRequest->merge(['not' => true]);
        $paginateRequest->modifyQuery($qbMock);

        # files
        $this->assertNull($paginateRequest->files);
        $paginateRequest->files();
        $this->assertInstanceOf(File::class, $paginateRequest->files);

        # items
        $paginateRequest->items($qbMock);
    }

}