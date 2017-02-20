<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Resize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttachmentTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Attachment::resizes
     * @covers \Belt\Clip\Attachment::scopeAttached
     * @covers \Belt\Clip\Attachment::scopeNotAttached
     * @covers \Belt\Clip\Attachment::sized
     * @covers \Belt\Clip\Attachment::__sized
     */
    public function test()
    {
        $attachment = factory(Attachment::class)->make();

        $attachment->resizes = new Collection();

        $attachment->resizes->push(factory(Resize::class)->make(['attachment' => $attachment, 'width' => 100, 'height' => 100]));
        $attachment->resizes->push(factory(Resize::class)->make(['attachment' => $attachment, 'width' => 200, 'height' => 200]));
        $attachment->resizes->push(factory(Resize::class)->make(['attachment' => $attachment, 'width' => 300, 'height' => 300]));

        # resizes
        $this->assertInstanceOf(HasMany::class, $attachment->resizes());
        $this->assertEquals(100, $attachment->sized(100, 100)->width);
        $this->assertEquals($attachment->width, $attachment->sized(123, 123)->width);

        # scopeAttached
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['attachments.*', 'clippables.position']);
        $qbMock->shouldReceive('join')->once()->with('clippables', 'clippables.attachment_id', '=', 'attachments.id');
        $qbMock->shouldReceive('where')->once()->with('clippables.clippable_type', 'pages');
        $qbMock->shouldReceive('where')->once()->with('clippables.clippable_id', 1);
        $qbMock->shouldReceive('orderBy')->once()->with('clippables.position');
        $attachment->scopeAttached($qbMock, 'pages', 1);

        # scopeNotAttached
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['attachments.*']);
        $qbMock->shouldReceive('leftJoin')->once()->with('clippables',
            m::on(function (\Closure $closure) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('on')->once()->with('clippables.attachment_id', '=', 'attachments.id');
                $subQBMock->shouldReceive('where')->once()->with('clippables.clippable_type', 'pages');
                $subQBMock->shouldReceive('where')->once()->with('clippables.clippable_id', 1);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $qbMock->shouldReceive('whereNull')->once()->with('clippables.id');
        $attachment->scopeNotAttached($qbMock, 'pages', 1);

    }

}