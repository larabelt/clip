<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Storage\File;
use Belt\Storage\Adapters\LocalAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;

class LocalAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Storage\Adapters\LocalAdapter::__construct
     * @covers \Belt\Storage\Adapters\LocalAdapter::src
     * @covers \Belt\Storage\Adapters\LocalAdapter::secure
     * @covers \Belt\Storage\Adapters\LocalAdapter::contents
     * @covers \Belt\Storage\Adapters\LocalAdapter::upload
     * @covers \Belt\Storage\Adapters\LocalAdapter::__create
     */
    public function test()
    {
        app()['config']->set('filesystems.disks.LocalAdapterTest', [
            'driver' => 'local',
            'root' => __DIR__ . '/../',
        ]);

        app()['config']->set('belt.storage.drivers.LocalAdapterTest', [
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

        $file = factory(File::class)->make();
        $file->name = 'test.jpg';
        $file->path = 'testing';

        $fileInfo = new UploadedFile(__DIR__ . '/../testing/test.jpg', 'test.jpg');

        # construct
        $adapter = new LocalAdapter('LocalAdapterTest');
        $this->assertNotNull($adapter->driver);
        $this->assertNotNull($adapter->disk);
        $this->assertNotEmpty($adapter->config);

        # src
        $this->assertEquals('http://localhost/images/testing/test.jpg', $adapter->src($file));

        # secure
        $this->assertEquals('https://localhost/images/testing/test.jpg', $adapter->secure($file));

        # secure
        $this->assertNotEmpty($adapter->contents($file));

        # upload
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('putFileAs')->once()->with('testing/test', $fileInfo, 'test.jpg')->andReturn(true);
        $disk->shouldReceive('putFileAs')->once()->with('testing/test', $fileInfo, 'invalid.jpg')->andReturn(false);
        $adapter->disk = $disk;
        $this->assertNotEmpty($adapter->upload('test', $fileInfo, 'test.jpg'));
        $this->assertNull($adapter->upload('test', $fileInfo, 'invalid.jpg'));

        # __create
        $sizes = getimagesize($fileInfo->getRealPath());
        $data = $adapter->__create('testing/test', $fileInfo, $file->name);
        $this->assertEquals('LocalAdapterTest', $data['driver']);
        $this->assertEquals($file->name, $data['name']);
        $this->assertEquals($fileInfo->getFilename(), $data['original_name']);
        $this->assertEquals('testing/test', $data['path']);
        $this->assertEquals($fileInfo->getSize(), $data['size']);
        $this->assertEquals($fileInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);

    }

}