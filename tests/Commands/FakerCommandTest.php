<?php

use Mockery as m;
use Ohio\Core\Testing\OhioTestCase;
use Ohio\Storage\Commands\FakerCommand;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Faker\Generator;

class FakerCommandTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Commands\FakerCommand::disk
     * @covers \Ohio\Storage\Commands\FakerCommand::faker
     * @covers \Ohio\Storage\Commands\FakerCommand::handle
     */
    public function testHandle()
    {

        $cmd = new FakerCommand();

        # disk
        $this->assertInstanceOf(Filesystem::class, $cmd->disk());

        # faker
        $this->assertInstanceOf(Generator::class, $cmd->faker());

        # handle
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('putFileAs')->times(3)->andReturn(true);

        $cmd = m::mock(FakerCommand::class . '[disk, option, info]');
        $cmd->shouldReceive('disk')->andReturn($disk);
        $cmd->shouldReceive('option')->with('limit')->andReturn(3);
        $cmd->shouldReceive('info')->andReturn(null);

        $cmd->handle();
    }

}