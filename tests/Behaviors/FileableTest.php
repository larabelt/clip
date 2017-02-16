<?php

use Mockery as m;

use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Behaviors\Fileable;
use Belt\Clip\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FileableTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Behaviors\Fileable::files
     * @covers \Belt\Clip\Behaviors\Fileable::getResizePresets
     * @covers \Belt\Clip\Behaviors\Fileable::getBelongsToManyCaller
     */
    public function test()
    {
        # files
        $morphMany = m::mock(Relation::class);
        $morphMany->shouldReceive('orderBy')->withArgs(['position']);
        $pageMock = m::mock(FileableTestStub::class . '[morphMany]');
        $pageMock->shouldReceive('morphMany')->withArgs([File::class, 'fileable'])->andReturn($morphMany);
        $pageMock->shouldReceive('files');
        $pageMock->files();

        # getResizePresets
        $this->assertNotEmpty(FileableTestStub::getResizePresets());

        # getBelongsToManyCaller
        $this->assertNotEmpty((new FileableTestStub)->files());
    }

}

class FileableTestStub extends Model
{
    use Fileable;

    public static $presets = [
        100, 100
    ];
}