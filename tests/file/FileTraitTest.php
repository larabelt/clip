<?php

use Mockery as m;
use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\File\File;
use Ohio\Storage\File\FileTrait;
use Ohio\Storage\File\Adapters\LocalAdapter;

class FileTraitTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\File\FileTrait::adapter
     * @covers \Ohio\Storage\File\FileTrait::getSrcAttribute
     * @covers \Ohio\Storage\File\FileTrait::getSecureAttribute
     * @covers \Ohio\Storage\File\FileTrait::getContentsAttribute
     * @covers \Ohio\Storage\File\FileTrait::setDriverAttribute
     * @covers \Ohio\Storage\File\FileTrait::setNameAttribute
     * @covers \Ohio\Storage\File\FileTrait::setOriginalNameAttribute
     * @covers \Ohio\Storage\File\FileTrait::setPathAttribute
     * @covers \Ohio\Storage\File\FileTrait::getRelPathAttribute
     * @covers \Ohio\Storage\File\FileTrait::setMimetypeAttribute
     * @covers \Ohio\Storage\File\FileTrait::setWidthAttribute
     * @covers \Ohio\Storage\File\FileTrait::setSizeAttribute
     * @covers \Ohio\Storage\File\FileTrait::setHeightAttribute
     * @covers \Ohio\Storage\File\FileTrait::createFromUpload
     * @covers \Ohio\Storage\File\FileTrait::getReadableSizeAttribute
     */
    public function test()
    {
        $file = factory(File::class)->make();
        $file->adapter = m::mock(LocalAdapter::class);
        $file->adapter->shouldReceive('src')->once()->andReturn('test');
        $file->adapter->shouldReceive('secure')->once()->andReturn('test');
        $file->adapter->shouldReceive('contents')->once()->andReturn('test');

        # adapter
        $this->assertInstanceOf(LocalAdapter::class, $file->adapter());

        # getSrcAttribute
        $this->assertEquals('test', $file->src);

        # getSecureAttribute
        $this->assertEquals('test', $file->secure);

        # contents
        $this->assertEquals('test', $file->contents);

        # driver
        $file->setDriverAttribute('test');
        $this->assertEquals('test', $file->driver);

        # name
        $file->setNameAttribute('test');
        $this->assertEquals('test', $file->name);

        # original name
        $file->setOriginalNameAttribute('test');
        $this->assertEquals('test', $file->original_name);

        # path
        $file->setPathAttribute('test');
        $this->assertEquals('test', $file->path);

        # rel path
        $this->assertEquals('test/test', $file->rel_path);

        # mimetype
        $file->setMimetypeAttribute('test');
        $this->assertEquals('test', $file->mimetype);

        # size
        $file->setSizeAttribute('test');
        $this->assertEquals('test', $file->size);

        # width
        $file->setWidthAttribute('test');
        $this->assertEquals('test', $file->width);

        # height
        $file->setHeightAttribute('test');
        $this->assertEquals('test', $file->height);

        # create from upload
        $this->assertNotEmpty(FileTraitTestStub::createFromUpload(['foo' => 'bar']));

        # get readable size
        $file->size = 1;
        $this->assertEquals('1 bytes', $file->readable_size);
        $file->size = 10000;
        $this->assertEquals('10 KB', $file->readable_size);
        $file->size = 2100000;
        $this->assertEquals('2.0 MB', $file->readable_size);
        $file->size = 3200000000;
        $this->assertEquals('3.0 GB', $file->readable_size);
    }

}

class FileTraitTestStub
{
    use FileTrait;

    public static function unguard()
    {

    }

    public static function create(array $attributes = [])
    {
        return true;
    }
}