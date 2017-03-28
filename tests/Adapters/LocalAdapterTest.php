<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\LocalAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;

class LocalAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Adapters\LocalAdapter::__construct
     * @covers \Belt\Clip\Adapters\LocalAdapter::src
     * @covers \Belt\Clip\Adapters\LocalAdapter::secure
     * @covers \Belt\Clip\Adapters\LocalAdapter::contents
     * @covers \Belt\Clip\Adapters\LocalAdapter::upload
     * @covers \Belt\Clip\Adapters\LocalAdapter::__create
     * @covers \Belt\Clip\Adapters\LocalAdapter::getFromPath
     */
    public function test()
    {
        app()['config']->set('filesystems.disks.LocalAdapterTest', [
            'driver' => 'local',
            'root' => __DIR__ . '/../',
        ]);

        app()['config']->set('belt.clip.drivers.LocalAdapterTest', [
            'disk' => 'LocalAdapterTest',
            'adapter' => LocalAdapter::class,
            'prefix' => 'testing',
            'src' => [
                'root' => 'http://localhost/images',
            ],
            'secure' => [
                'root' => 'https://localhost/images',
            ],
        ]);

        $attachment = factory(Attachment::class)->make();
        $attachment->name = 'test.jpg';
        $attachment->path = 'testing';

        $attachmentInfo = new UploadedFile(__DIR__ . '/../testing/test.jpg', 'test.jpg');

        # construct
        $adapter = new LocalAdapter('LocalAdapterTest');
        $this->assertNotNull($adapter->driver);
        $this->assertNotNull($adapter->disk);
        $this->assertNotEmpty($adapter->config);

        # src
        $this->assertEquals('http://localhost/images/testing/test.jpg', $adapter->src($attachment));

        # secure
        $this->assertEquals('https://localhost/images/testing/test.jpg', $adapter->secure($attachment));

        # secure
        $this->assertNotEmpty($adapter->contents($attachment));

        # upload
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('putFileAs')->once()->with('testing/test', $attachmentInfo, 'test.jpg')->andReturn(true);
        $disk->shouldReceive('putFileAs')->once()->with('testing/test', $attachmentInfo, 'invalid.jpg')->andReturn(false);
        $adapter->disk = $disk;
        $this->assertNotEmpty($adapter->upload('test', $attachmentInfo, 'test.jpg'));
        $this->assertNull($adapter->upload('test', $attachmentInfo, 'invalid.jpg'));

        # __create
        $sizes = getimagesize($attachmentInfo->getRealPath());
        $data = $adapter->__create('testing/test', $attachmentInfo, $attachment->name);
        $this->assertEquals('LocalAdapterTest', $data['driver']);
        $this->assertEquals($attachment->name, $data['name']);
        $this->assertEquals($attachmentInfo->getFilename(), $data['original_name']);
        $this->assertEquals('testing/test', $data['path']);
        $this->assertEquals($attachmentInfo->getSize(), $data['size']);
        $this->assertEquals($attachmentInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);

        # getFromPath
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('exists')->once()->with('testing/test.jpg')->andReturn(true);
        $disk->shouldReceive('exists')->once()->with('testing/invalid.jpg')->andReturn(false);
        $adapter->disk = $disk;
        $result = $adapter->getFromPath('testing', 'test.jpg');
        $this->assertNotEmpty($result);
        $result = $adapter->getFromPath('testing', 'invalid.jpg');
        $this->assertEmpty($result);
    }

}