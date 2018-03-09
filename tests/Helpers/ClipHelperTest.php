<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Resize;
use Belt\Clip\Adapters\LocalAdapter;
use Belt\Clip\Helpers\ClipHelper;
use Belt\Clip\Helpers\SrcHelper;

class ClipHelperTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Helpers\ClipHelper::__construct
     * @covers \Belt\Clip\Helpers\ClipHelper::setAttachment
     * @covers \Belt\Clip\Helpers\ClipHelper::getAttachment
     * @covers \Belt\Clip\Helpers\ClipHelper::setParams
     * @covers \Belt\Clip\Helpers\ClipHelper::param
     * @covers \Belt\Clip\Helpers\ClipHelper::proportionallyResize
     * @covers \Belt\Clip\Helpers\ClipHelper::src
     */
    public function testHandle()
    {
        app()['config']->set('belt.clip.drivers.ClipHelperTest', [
            'disk' => 'local',
            'adapter' => LocalAdapter::class,
            'prefix' => 'testing',
            'src' => [
                'root' => 'http://localhost/images',
            ],
            'secure' => [
                'root' => 'https://localhost/images',
            ],
        ]);

        $attachment = factory(Attachment::class)->make([
            'driver' => 'ClipHelperTest',
            'name' => 'test.jpg',
            'path' => 'testing',
            'width' => 400,
            'height' => 300,
        ]);

        $helper = new ClipHelper($attachment);

        # __construct
        # setAttachment
        # getAttachment
        $this->assertEquals($attachment, $helper->getAttachment());

        # params
        $helper->setParams([
            100,
            null,
            ['foo' => 'bar'],
            ['proportionallyResize' => true],
        ]);
        $this->assertEquals(100, $helper->param('width'));
        $this->assertEquals('bar', $helper->param('foo'));

        # proportionallyResize
        $this->assertFalse($helper->proportionallyResize(400, 300));
        $this->assertEquals([100, 75], $helper->proportionallyResize(400, 300, 100));
        $this->assertEquals([133, 100], $helper->proportionallyResize(400, 300, null, 100));
        $this->assertEquals([100, 133], $helper->proportionallyResize(300, 400, 100));
        $this->assertEquals([75, 100], $helper->proportionallyResize(300, 400, null, 100));
        $this->assertEquals([300, 400], $helper->proportionallyResize(75, 100, 300));

        $this->assertEquals([225, 300], $helper->proportionallyResize(75, 100, 400, 300));
        $this->assertEquals([300, 225], $helper->proportionallyResize(100, 75, 300, 400));

        # src (no resizes or macros)
        $this->assertEquals($attachment->src, $helper->src(500, 50));

        # src (macro)
        SrcHelper::macro('ClipHelperTest', function ($helper) {
            return 'bar';
        });
        $this->assertEquals('bar', $helper->src(500, 50));

        # src (resize)
        $attachment->resizes = new \Illuminate\Database\Eloquent\Collection();
        $resize = factory(Resize::class)->make([
            'attachment' => $attachment,
            'driver' => 'ClipHelperTest',
            'name' => 'bar.jpg',
            'path' => 'foo',
            'width' => 500,
            'height' => 50,
        ]);
        $attachment->resizes->add($resize);
        $this->assertEquals($resize->src, $helper->src(500, 50));

    }

}