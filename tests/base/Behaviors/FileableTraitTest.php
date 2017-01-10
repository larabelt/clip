<?php

use Mockery as m;

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\Base\Behaviors\FileableTrait;
use Ohio\Storage\File\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FileableTraitTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\Base\Behaviors\FileableTrait::files
     */
    public function test()
    {
        # files
        $morphMany = m::mock(Relation::class);
        $morphMany->shouldReceive('orderby')->withArgs(['delta']);
        $pageMock = m::mock(FileableTraitTestStub::class . '[morphMany]');
        $pageMock->shouldReceive('morphMany')->withArgs([File::class, 'fileable'])->andReturn($morphMany);
        $pageMock->shouldReceive('files');
        $pageMock->files();
    }

}

class FileableTraitTestStub extends Model
{
    use FileableTrait;
}