<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\AttachmentTrait;
use Belt\Clip\Adapters\LocalAdapter;

class AttachmentTraitTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\AttachmentTrait::adapter
     * @covers \Belt\Clip\AttachmentTrait::getSrcAttribute
     * @covers \Belt\Clip\AttachmentTrait::getSecureAttribute
     * @covers \Belt\Clip\AttachmentTrait::getContentsAttribute
     * @covers \Belt\Clip\AttachmentTrait::setDriverAttribute
     * @covers \Belt\Clip\AttachmentTrait::setNameAttribute
     * @covers \Belt\Clip\AttachmentTrait::setOriginalNameAttribute
     * @covers \Belt\Clip\AttachmentTrait::setPathAttribute
     * @covers \Belt\Clip\AttachmentTrait::getRelPathAttribute
     * @covers \Belt\Clip\AttachmentTrait::setMimetypeAttribute
     * @covers \Belt\Clip\AttachmentTrait::setWidthAttribute
     * @covers \Belt\Clip\AttachmentTrait::setSizeAttribute
     * @covers \Belt\Clip\AttachmentTrait::setHeightAttribute
     * @covers \Belt\Clip\AttachmentTrait::createFromUpload
     * @covers \Belt\Clip\AttachmentTrait::getReadableSizeAttribute
     * @covers \Belt\Clip\AttachmentTrait::getIsImageAttribute
     * @covers \Belt\Clip\AttachmentTrait::setAttributesFromUpload
     */
    public function test()
    {
        $attachment = factory(Attachment::class)->make();
        $attachment->adapter = m::mock(LocalAdapter::class);
        $attachment->adapter->shouldReceive('src')->once()->andReturn('test');
        $attachment->adapter->shouldReceive('secure')->once()->andReturn('test');
        $attachment->adapter->shouldReceive('contents')->once()->andReturn('test');

        # adapter
        $this->assertInstanceOf(LocalAdapter::class, $attachment->adapter());

        # getSrcAttribute
        $this->assertEquals('test', $attachment->src);

        # getSecureAttribute
        $this->assertEquals('test', $attachment->secure);

        # contents
        $this->assertEquals('test', $attachment->contents);

        # driver
        $attachment->setDriverAttribute('test');
        $this->assertEquals('test', $attachment->driver);

        # name
        $attachment->setNameAttribute('test.jpg');
        $this->assertEquals('test.jpg', $attachment->name);

        # original name
        $attachment->setOriginalNameAttribute('test');
        $this->assertEquals('test', $attachment->original_name);

        # path
        $attachment->setPathAttribute('test');
        $this->assertEquals('test', $attachment->path);

        # rel path
        $this->assertEquals('test/test.jpg', $attachment->rel_path);
        $attachment2 = clone $attachment;
        $attachment2->path = null;
        $this->assertEquals('test.jpg', $attachment2->rel_path);
        $attachment2->name = null;
        $this->assertNull($attachment2->rel_path);

        # mimetype
        $attachment->setMimetypeAttribute('test');
        $this->assertEquals('test', $attachment->mimetype);

        # is_image
        $this->assertFalse($attachment->is_image);
        $attachment->setMimetypeAttribute('image/jpeg');
        $this->assertTrue($attachment->is_image);

        # size
        $attachment->setSizeAttribute('test');
        $this->assertEquals('test', $attachment->size);

        # width
        $attachment->setWidthAttribute('test');
        $this->assertEquals(0, $attachment->width);

        # height
        $attachment->setHeightAttribute('test');
        $this->assertEquals(0, $attachment->height);

        # create from upload
        $this->assertNotEmpty(AttachmentTraitTestStub::createFromUpload(['foo' => 'bar']));

        # get readable size
        $attachment->size = 1;
        $this->assertEquals('1 bytes', $attachment->readable_size);
        $attachment->size = 10000;
        $this->assertEquals('10 KB', $attachment->readable_size);
        $attachment->size = 2100000;
        $this->assertEquals('2.0 MB', $attachment->readable_size);
        $attachment->size = 3200000000;
        $this->assertEquals('3.0 GB', $attachment->readable_size);
    }

}

class AttachmentTraitTestStub
{
    use AttachmentTrait;

    public static function unguard()
    {

    }

    public static function create(array $attributes = [])
    {
        return true;
    }
}