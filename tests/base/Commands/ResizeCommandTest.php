<?php

use Mockery as m;
use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\Base\Commands\ResizeCommand;
use Ohio\Storage\File\Services\ResizeService;
use Illuminate\Filesystem\FilesystemAdapter;

class ResizeCommandTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Base\Commands\ResizeCommand::service
     * @covers \Ohio\Storage\Base\Commands\ResizeCommand::handle
     */
    public function testHandle()
    {

        $cmd = new ResizeCommand();

        # service
        $this->assertInstanceOf(ResizeService::class, $cmd->service());

        # handle
        $service = m::mock(ResizeService::class);
        $service->shouldReceive('batch')->andReturn(true);

        $cmd = m::mock(ResizeCommand::class . '[service]');
        $cmd->shouldReceive('service')->andReturn($service);

        $cmd->handle();
    }

}