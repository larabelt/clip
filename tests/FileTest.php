<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\File;
use Belt\Clip\Resize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\File::resizes
     * @covers \Belt\Clip\File::scopeFiled
     * @covers \Belt\Clip\File::scopeNotFiled
     * @covers \Belt\Clip\File::sized
     * @covers \Belt\Clip\File::__sized
     */
    public function test()
    {
        $file = factory(File::class)->make();

        $file->resizes->push(factory(Resize::class)->make(['file' => $file, 'width' => 100, 'height' => 100]));
        $file->resizes->push(factory(Resize::class)->make(['file' => $file, 'width' => 200, 'height' => 200]));
        $file->resizes->push(factory(Resize::class)->make(['file' => $file, 'width' => 300, 'height' => 300]));

        # resizes
        $this->assertInstanceOf(HasMany::class, $file->resizes());
        $this->assertEquals(100, $file->sized(100, 100)->width);
        $this->assertEquals($file->width, $file->sized(123, 123)->width);

        # scopeFiled
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['files.*']);
        $qbMock->shouldReceive('join')->once()->with('fileables', 'fileables.file_id', '=', 'files.id');
        $qbMock->shouldReceive('where')->once()->with('fileables.fileable_type', 'pages');
        $qbMock->shouldReceive('where')->once()->with('fileables.fileable_id', 1);
        $qbMock->shouldReceive('orderBy')->once()->with('fileables.position');
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