<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Commands\MoveCommand;
use Belt\Clip\Services\MoveService;

class MoveCommandTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Commands\MoveCommand::service
     * @covers \Belt\Clip\Commands\MoveCommand::handle
     */
    public function testHandle()
    {

        $cmd = new MoveCommand();

        # service
        $this->assertInstanceOf(MoveService::class, $cmd->service());

        # handle
        $arguments = [
            'source' => 'path/to/source',
            'target' => 'path/to/target',
        ];
        $options = [
            'ids' => '1,2,3',
            'limit' => '100',
            'path' => '',
        ];

        $service = m::mock(MoveService::class);
        $service->shouldReceive('move')->with($arguments['source'], $arguments['target'], $options)->andReturn(true);

        $cmd = m::mock(MoveCommand::class . '[service,argument,option]');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->shouldReceive('argument')->with('source')->andReturn($arguments['source']);
        $cmd->shouldReceive('argument')->with('target')->andReturn($arguments['target']);
        $cmd->shouldReceive('option')->with('ids')->andReturn($options['ids']);
        $cmd->shouldReceive('option')->with('limit')->andReturn($options['limit']);
        $cmd->shouldReceive('option')->with('path')->andReturn($options['path']);

        $cmd->handle();
    }

}