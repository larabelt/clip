<?php
use Mockery as m;

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\File\File;
use Illuminate\Database\Eloquent\Builder;

class FileTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\File\File::__toString
     * @covers \Ohio\Storage\File\File::setBodyAttribute
     * @covers \Ohio\Storage\File\File::scopeFiled
     * @covers \Ohio\Storage\File\File::scopeNotFiled
     */
    public function test()
    {
        $file = factory(File::class)->make();

        # __toString
        $file->name = ' Test ';
        $this->assertEquals($file->name, $file->__toString());

        # setBodyAttribute
        $file->body = ' Test ';
        $this->assertEquals('Test', $file->body);

        # scopeFiled
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['files.*']);
        $qbMock->shouldReceive('join')->once()->with('fileables', 'fileables.file_id', '=', 'files.id');
        $qbMock->shouldReceive('where')->once()->with('fileables.fileable_type', 'pages');
        $qbMock->shouldReceive('where')->once()->with('fileables.fileable_id', 1);
        $file->scopeFiled($qbMock, 'pages', 1);

        # scopeNotFiled
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['files.*']);
        $qbMock->shouldReceive('leftJoin')->once()->with('fileables',
            m::on(function (\Closure $closure) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('on')->once()->with('fileables.file_id', '=', 'files.id');
                $subQBMock->shouldReceive('where')->once()->with('fileables.fileable_type', 'pages');
                $subQBMock->shouldReceive('where')->once()->with('fileables.fileable_id', 1);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $qbMock->shouldReceive('whereNull')->once()->with('fileables.id');
        $file->scopeNotFiled($qbMock, 'pages', 1);

    }

}