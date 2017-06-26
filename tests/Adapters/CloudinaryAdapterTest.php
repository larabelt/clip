<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\CloudinaryAdapter;
use Belt\Clip\Services\Cloudinary\CloudinaryFlysystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;


class CloudinaryAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::src
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::secure
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::upload
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::__create
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::getFromPath
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::diskAdapter
     * @covers \Belt\Clip\Adapters\CloudinaryAdapter::contents
     */
    public function test()
    {
        app()['config']->set('filesystems.disks.CloudinaryAdapterTest', [
            'driver' => 'local',
            'root' => __DIR__ . '/../',
        ]);

        app()['config']->set('belt.clip.drivers.CloudinaryAdapterTest', [
            'disk' => 'CloudinaryAdapterTest',
            'adapter' => CloudinaryAdapter::class,
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

        $attachmentInfo = new UploadedFile(__DIR__ . '/test.jpg', 'test.jpg');

        $adapter = new CloudinaryAdapter('CloudinaryAdapterTest');

        # src
        $this->assertEquals('http://localhost/images/testing/test.jpg', $adapter->src($attachment));

        # secure
        $this->assertEquals('https://localhost/images/testing/test.jpg', $adapter->secure($attachment));

        # secure
        $this->assertNotEmpty($adapter->contents($attachment));

        # upload
        $adapter = m::mock(CloudinaryAdapter::class . '[__create]', ['CloudinaryAdapterTest']);
        $adapter->shouldReceive('__create')->andReturn(true);
        $adapter->disk = m::mock(FilesystemAdapter::class);
        $adapter->disk->shouldReceive('putFileAs')->andReturn(true);
        $this->assertNotEmpty($adapter->upload('test', $attachmentInfo, 'test.jpg'));

        # upload (fail)
        $adapter = new CloudinaryAdapter('CloudinaryAdapterTest');
        $adapter->disk = m::mock(FilesystemAdapter::class);
        $adapter->disk->shouldReceive('putFileAs')->andReturn(false);
        $this->assertNull($adapter->upload('test', $attachmentInfo, 'invalid.jpg'));

        # __create
        $diskAdapter = m::mock(CloudinaryFlysystemAdapter::class);
        $diskAdapter->shouldReceive('getResponse')->andReturn([
            'rel_path' => 'testing/test',
            'basename' => 'test.jpg',
        ]);
        $adapter = new CloudinaryAdapter('CloudinaryAdapterTest');
        $adapter->diskAdapter = $diskAdapter;
        $sizes = getimagesize($attachmentInfo->getRealPath());
        $data = $adapter->__create('testing/test', $attachmentInfo, $attachment->name);
        $this->assertEquals('CloudinaryAdapterTest', $data['driver']);
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

        # contents
        $adapter = new CloudinaryAdapter('CloudinaryAdapterTest');
        $adapter->disk = m::mock(FilesystemAdapter::class);
        $adapter->disk->shouldReceive('get')->once()->with($attachment->rel_path);
        $adapter->contents($attachment);
    }

}