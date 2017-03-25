<?php

use Mockery as m;

use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Behaviors\Clippable;
use Belt\Clip\Attachment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ClippableTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Behaviors\Clippable::attachments
     * @covers \Belt\Clip\Behaviors\Clippable::getResizePresets
     * @covers \Belt\Clip\Behaviors\Clippable::getBelongsToManyCaller
     */
    public function test()
    {
        # attachments
        $morphMany = m::mock(Relation::class);
        $morphMany->shouldReceive('orderBy')->withArgs(['position']);
        $pageMock = m::mock(ClippableTestStub::class . '[morphMany]');
        $pageMock->shouldReceive('morphMany')->withArgs([Attachment::class, 'clippable'])->andReturn($morphMany);
        $pageMock->shouldReceive('attachments');
        $pageMock->attachments();

        # getResizePresets
        $this->assertNotEmpty(ClippableTestStub::getResizePresets());

        # getBelongsToManyCaller
        $this->assertNotEmpty((new ClippableTestStub)->attachments());
    }

}

class ClippableTestStub extends Model
{
    use Belt\Core\Behaviors\HasSortableTrait;
    use Clippable;

    public static $presets = [
        100, 100
    ];
}