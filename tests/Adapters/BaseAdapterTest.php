<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\BaseAdapter;
use Belt\Clip\Adapters\LocalAdapter;
use Belt\Clip\Helpers\SrcHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;

class BaseAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Clip\Adapters\BaseAdapter::__construct
     * @covers \Belt\Clip\Adapters\BaseAdapter::config
     * @covers \Belt\Clip\Adapters\BaseAdapter::randomFilename
     * @covers \Belt\Clip\Adapters\BaseAdapter::normalizePath
     * @covers \Belt\Clip\Adapters\BaseAdapter::prefixedPath
     * @covers \Belt\Clip\Adapters\BaseAdapter::__create
     * @covers \Belt\Clip\Adapters\BaseAdapter::loadMacros
     *
     * @covers \Belt\Clip\Adapters\BaseAdapter::src
     * @covers \Belt\Clip\Adapters\BaseAdapter::secure
     * @covers \Belt\Clip\Adapters\BaseAdapter::contents
     * @covers \Belt\Clip\Adapters\BaseAdapter::upload
     * @covers \Belt\Clip\Adapters\BaseAdapter::getFromPath
     */
    public function test()
    {
        $attachment = factory(Attachment::class)->make();
        $attachment->name = 'test.jpg';
        $attachment->attachment_path = 'public/images/test.jpg';
        $attachment->web_path = 'images/test.jpg';

        $attachmentInfo = new UploadedFile(__DIR__ . '/../testing/test.jpg', 'test.jpg');

        app()['config']->set('belt.clip.drivers.BaseAdapterTest', [
            'disk' => 'public',
            'adapter' => LocalAdapter::class,
            'prefix' => 'testing',
            'src' => [
                'root' => 'http://localhost',
            ],
            'secure' => [
                'root' => 'http://localhost',
            ],
        ]);

        # construct
        $exception = false;
        try {
            new BaseAdapterTestStub('MissingDiskBaseAdapterTest');
        } catch (\Exception $e) {
            $exception = true;
        };
        $this->assertTrue($exception);


        $adapter = new BaseAdapterTestStub('BaseAdapterTest');
        $this->assertNotNull($adapter->driver);
        $this->assertNotNull($adapter->disk);
        $this->assertNotEmpty($adapter->config);

        # loadMacros
        $this->assertEquals('test', SrcHelper::baseAdapterTestStub());

        # config
        $adapter->config = array_merge($adapter->config, ['foo' => 'bar']);
        $this->assertEquals('bar', $adapter->config('foo'));
        $this->assertEquals('default', $adapter->config('missing', 'default'));
        $this->assertEquals($adapter->config, $adapter->config());

        # randomFilename
        $randomFilename = $adapter->randomFilename($attachmentInfo);
        $randomFilename = explode('.', $randomFilename);
        $this->assertEquals(2, count($randomFilename));
        $this->assertTrue(in_array($randomFilename[1], ['jpg', 'jpeg']));
        $fileInfo = m::mock(UploadedFile::class);
        $fileInfo->shouldReceive('guessExtension')->once()->andReturn('jpg');
        $this->assertTrue(str_contains($adapter->randomFilename($fileInfo), ['.jpg', date('Ymd')]));

        # normalizePath
        $this->assertEquals('test', $adapter->normalizePath('test'));
        $this->assertEquals('test', $adapter->normalizePath('test/'));
        $this->assertEquals('test', $adapter->normalizePath('/test'));
        $this->assertEquals('test', $adapter->normalizePath('/test/'));
        $this->assertEquals('test/test', $adapter->normalizePath('/test/test/'));
        $this->assertEquals('test/test', $adapter->normalizePath('/test//test/'));
        $this->assertEquals('test/test', $adapter->normalizePath(['test', 'test']));

        # prefixedPath
        $this->assertEquals('testing/test/test.jpg', $adapter->prefixedPath('/test/', $attachment->name));

        # __create
        $sizes = getimagesize($attachmentInfo->getRealPath());
        $data = $adapter->__create('testing/test', $attachmentInfo, $attachment->name);
        $this->assertEquals($adapter->driver, $data['driver']);
        $this->assertEquals($attachment->name, $data['name']);
        $this->assertEquals($attachmentInfo->getFilename(), $data['original_name']);
        $this->assertEquals('testing/test', $data['path']);
        $this->assertEquals($attachmentInfo->getSize(), $data['size']);
        $this->assertEquals($attachmentInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);

        # tests moved from LocalAdapter
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

class BaseAdapterTestStub extends BaseAdapter
{
    public static function loadMacros($driver)
    {
        SrcHelper::macro('baseAdapterTestStub', function () {
            return 'test';
        });
    }
}