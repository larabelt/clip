<?php

use Mockery as m;

use Ohio\Core\Testing\OhioTestCase;
use Ohio\Storage\Behaviors\FileableTrait;
use Ohio\Storage\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FileableTraitTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Behaviors\FileableTrait::files
     * @covers \Ohio\Storage\Behaviors\FileableTrait::getResizePresets
     * @covers \Ohio\Storage\Behaviors\FileableTrait::getBelongsToManyCaller
     */
    public function test()
    {
        # files
        $morphMany = m::mock(Relation::class);
        $morphMany->shouldReceive('orderBy')->withArgs(['position']);
        $pageMock = m::mock(FileableTraitTestStub::class . '[morphMany]');
        $pageMock->shouldReceive('morphMany')->withArgs([File::class, 'fileable'])->andReturn($morphMany);
        $pageMock->shouldReceive('files');
        $pageMock->files();

        # getResizePresets
        $this->assertNotEmpty(FileableTraitTestStub::getResizePresets());

        # getBelongsToManyCaller
        $this->assertNotEmpty((new FileableTraitTestStub)->files());
    }

}

class FileableTraitTestStub extends Model
{
    use FileableTrait;

    public static $presets = [
        100, 100
    ];
}