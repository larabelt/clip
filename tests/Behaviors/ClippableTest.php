<?php

use Mockery as m;

use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Behaviors\Clippable;
use Belt\Clip\Album;
use Belt\Clip\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class ClippableTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Behaviors\Clippable::attachment
     * @covers \Belt\Clip\Behaviors\Clippable::attachments
     * @covers \Belt\Clip\Behaviors\Clippable::getResizePresets
     * @covers \Belt\Clip\Behaviors\Clippable::purgeAttachments
     * @covers \Belt\Clip\Behaviors\Clippable::getImageAttribute
     * @covers \Belt\Clip\Behaviors\Clippable::getImagesAttribute
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
        $this->assertEmpty(ClippableTestStub3::getResizePresets());
        app()['config']->set('belt.clip.resize.models.' . ClippableTestStub3::class, [
            [100, 100, 'fit'],
            [800, 800, 'fit'],
        ]);
        $this->assertNotEmpty(ClippableTestStub3::getResizePresets());

        # purgeAttachments
        $clippable = new ClippableTestStub();
        $clippable->id = 1;
        DB::shouldReceive('connection')->once()->andReturnSelf();
        DB::shouldReceive('table')->once()->with('clippables')->andReturnSelf();
        DB::shouldReceive('where')->once()->with('clippable_id', 1)->andReturnSelf();
        DB::shouldReceive('where')->once()->with('clippable_type', 'clippableTestStub')->andReturnSelf();
        DB::shouldReceive('delete')->once()->andReturnSelf();
        $clippable->purgeAttachments();

        # attachment
        $this->assertInstanceOf(BelongsTo::class, $clippable->attachment());

        # getImageAttribute
        Attachment::unguard();
        $clippable = factory(Album::class)->make();
        $this->assertNull($clippable->getImageAttribute());
        $clippable->attachments = new \Illuminate\Support\Collection();
        $clippable->attachments->push(factory(Attachment::class)->make(['mimetype' => 'application/pdf']));
        $this->assertNull($clippable->getImageAttribute());
        $clippable->attachments->push(factory(Attachment::class)->make(['mimetype' => 'image/png']));
        $this->assertInstanceOf(Attachment::class, $clippable->getImageAttribute());

        # getImagesAttribute
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $clippable->getImagesAttribute());
        $this->assertGreaterThan(0, $clippable->attachments->count());
    }

    /**
     * @covers \Belt\Clip\Behaviors\Clippable::attachAttachment
     */
    public function testAttachAttachment()
    {
        Attachment::unguard();

        # works
        $attachment = m::mock(Attachment::class . '[touch]', ['id' => 1]);
        $attachment->shouldReceive('touch')->andReturnSelf();

        $attachmentsRelation = m::mock(\Rutorika\Sortable\BelongsToSortedMany::class);
        $attachmentsRelation->shouldReceive('attach')->andReturnSelf();

        $album = m::mock(Album::class . '[attachments]');
        $album->attachments = new \Illuminate\Support\Collection();
        $album->shouldReceive('attachments')->andReturn($attachmentsRelation);

        $album->attachAttachment($attachment);

        # fails
        $attachment = m::mock(Attachment::class . '[touch]', ['id' => 1]);
        $attachment->shouldReceive('touch')->andReturnSelf();

        $attachmentsRelation = m::mock(\Rutorika\Sortable\BelongsToSortedMany::class);
        $attachmentsRelation->shouldReceive('attach')->andThrow(new \Exception());

        $album = m::mock(Album::class . '[attachments]');
        $album->attachments = new \Illuminate\Support\Collection();
        $album->shouldReceive('attachments')->andReturn($attachmentsRelation);

        $album->attachAttachment($attachment);
    }

}

class ClippableTestStub extends Model
{
    use Belt\Core\Behaviors\HasSortableTrait;
    use Clippable;

    public static $presets = [
        100,
        100
    ];

    public function getMorphClass()
    {
        return 'clippableTestStub';
    }
}

class ClippableTestStub2 extends Model
{
    use Clippable;

    public static $presets = [
        100,
        100
    ];

    public function getMorphClass()
    {
        return 'clippableTestStub';
    }
}

class ClippableTestStub3
{
    use Clippable;

    public function getMorphClass()
    {
        return 'clippableTestStub';
    }
}