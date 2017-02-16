<?php

use Mockery as m;

use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Behaviors\Clippable;
use Belt\Clip\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ClippableTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Behaviors\Clippable::files
     * @covers \Belt\Clip\Behaviors\Clippable::getResizePresets
     * @covers \Belt\Clip\Behaviors\Clippable::getBelongsToManyCaller
     */
    public function test()
    {
        # files
        $morphMany = m::mock(Relation::class);
        $morphMany->shouldReceive('orderBy')->withArgs(['position']);
        $pageMock = m::mock(ClippableTestStub::class . '[morphMany]');
        $pageMock->shouldReceive('morphMany')->withArgs([File::class, 'clippable'])->andReturn($morphMany);
        $pageMock->shouldReceive('files');
        $pageMock->files();

        # getResizePresets
        $this->assertNotEmpty(ClippableTestStub::getResizePresets());

        # getBelongsToManyCaller
        $this->assertNotEmpty((new ClippableTestStub)->files());
    }

}

class ClippableTestStub extends Model
{
    use Clippable;

    public static $presets = [
        100, 100
    ];
}