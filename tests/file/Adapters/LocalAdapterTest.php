<?php

use Mockery as m;
use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Adapters\LocalAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;

class LocalAdapterTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::__construct
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::src
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::secure
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::contents
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::upload
     * @covers \Ohio\Storage\File\Adapters\LocalAdapter::__create
     */
    public function test()
    {
        $file = factory(File::class)->make();
        $file->name = 'test.jpg';
        $file->file_path = 'test.jpg';
        $file->web_path = 'images/test.jpg';

        $fileInfo = new UploadedFile(__DIR__ . '/../../test.jpg', 'test.jpg');

        // config
        $config = [
            'adapter' => LocalAdapter::class,
            'driver' => 'local',
            'root' => __DIR__ . '/../../',
            'http' => 'http://localhost',
            'https' => 'https://localhost',
            'web_prefix' => 'storage',
        ];
        app()['config']->set('ohio.storage.disks.LocalAdapterTest', $config);
        app()['config']->set('filesystems.disks.LocalAdapterTest', $config);

        # construct
        $adapter = new LocalAdapter('LocalAdapterTest');
        $this->assertNotNull($adapter->key);
        $this->assertNotNull($adapter->disk);
        $this->assertNotEmpty($adapter->config);

        # src
        $this->assertEquals('http://localhost/images/test.jpg', $adapter->src($file));

        # secure
        $this->assertEquals('https://localhost/images/test.jpg', $adapter->secure($file));

        # secure
        $this->assertNotEmpty($adapter->contents($file));

        # upload
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('putFileAs')->once()->with('test', $fileInfo, 'test.jpg')->andReturn(true);
        $disk->shouldReceive('putFileAs')->once()->with('test', $fileInfo, 'invalid.jpg')->andReturn(false);
        $adapter->disk = $disk;
        $this->assertNotEmpty($adapter->upload('test', $fileInfo, 'test.jpg'));
        $this->assertNull($adapter->upload('test', $fileInfo, 'invalid.jpg'));

        # __create
        $sizes = getimagesize($fileInfo->getRealPath());
        $data = $adapter->__create('test', $fileInfo, $file->name);
        $this->assertEquals('LocalAdapterTest', $data['disk']);
        $this->assertEquals($file->name, $data['name']);
        $this->assertEquals($fileInfo->getFilename(), $data['original_name']);
        $this->assertEquals('test/test.jpg', $data['file_path']);
        $this->assertEquals('storage/test/test.jpg', $data['web_path']);
        $this->assertEquals($fileInfo->getSize(), $data['size']);
        $this->assertEquals($fileInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);

    }

}