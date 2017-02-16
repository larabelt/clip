<?php
use Mockery as m;
use Belt\Core\Testing;

use Belt\Clip\Attachment;
use Belt\Clip\Http\Requests\PaginateClippables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateClippablesTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Http\Requests\PaginateClippables::modifyQuery
     * @covers \Belt\Clip\Http\Requests\PaginateClippables::items
     */
    public function test()
    {
        $attachment1 = new Attachment();
        $attachment1->id = 1;
        $attachment1->name = 'attachment 1';

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('attached')->once()->with('pages', 1);
        $qbMock->shouldReceive('notAttached')->once()->with('pages', 1);
        $qbMock->shouldReceive('get')->once()->andReturn(new Collection([$attachment1]));

        # modifyQuery
        $paginateRequest = new PaginateClippables(['clippable_id' => 1, 'clippable_type' => 'pages']);
        $paginateRequest->modifyQuery($qbMock);
        $paginateRequest->merge(['not' => true]);
        $paginateRequest->modifyQuery($qbMock);

//        # attachments
//        s($paginateRequest->attachments);
//        $this->assertNull($paginateRequest->attachments);
//        $paginateRequest->attachments();
//        $this->assertInstanceOf(Attachment::class, $paginateRequest->attachments);

        # items
        $paginateRequest->items($qbMock);
    }

}