<?php

use Mockery as m;
use Belt\Clip\Jobs\MoveAttachment;
use Belt\Core\Testing;
use Belt\Clip\Attachment;
use Belt\Clip\Services\MoveService;

class MoveAttachmentTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Jobs\MoveAttachment::__construct
     * @covers \Belt\Clip\Jobs\MoveAttachment::service
     * @covers \Belt\Clip\Jobs\MoveAttachment::handle
     */
    public function test()
    {
        $attachment = factory(Attachment::class)->make();
        $target = 'foo';
        $options = ['foo' => 'bar'];
        $job = new MoveAttachment($attachment, $target, $options);

        # service
        $this->assertInstanceOf(MoveService::class, $job->service());

        # handle
        $service = m::mock(MoveService::class . '[move]');
        $service->shouldReceive('move')->with($attachment, $target, $options)->andReturnSelf();
        $job->service = $service;
        $job->handle();
    }

}