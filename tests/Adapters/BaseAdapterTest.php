<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Storage\File;
use Belt\Storage\Adapters\BaseAdapter;
use Illuminate\Http\UploadedFile;

class BaseAdapterTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Storage\Adapters\BaseAdapter::__construct
     * @covers \Belt\Storage\Adapters\BaseAdapter::config
     * @covers \Belt\Storage\Adapters\BaseAdapter::randomFilename
     * @covers \Belt\Storage\Adapters\BaseAdapter::normalizePath
     * @covers \Belt\Storage\Adapters\BaseAdapter::prefixedPath
     * @covers \Belt\Storage\Adapters\BaseAdapter::__create
     */
    public function test()
    {
        $file = factory(File::class)->make();
        $file->name = 'test.jpg';
        $file->file_path = 'public/images/test.jpg';
        $file->web_path = 'images/test.jpg';

        $fileInfo = new UploadedFile(__DIR__ . '/../testing/test.jpg', 'test.jpg');

        app()['config']->set('belt.storage.drivers.BaseAdapterTest', [
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

        # config
        $adapter->config = array_merge($adapter->config, ['foo' => 'bar']);
        $this->assertEquals('bar', $adapter->config('foo'));
        $this->assertEquals('default', $adapter->config('missing', 'default'));
        $this->assertEquals($adapter->config, $adapter->config());

        # randomFilename
        $randomFilename = $adapter->randomFilename($fileInfo);
        $randomFilename = explode('.', $randomFilename);
        $this->assertEquals(2, count($randomFilename));
        $this->assertTrue(in_array($randomFilename[1], ['jpg', 'jpeg']));

        # normalizePath
        $this->assertEquals('test', $adapter->normalizePath('test'));
        $this->assertEquals('test', $adapter->normalizePath('test/'));
        $this->assertEquals('test', $adapter->normalizePath('/test'));
        $this->assertEquals('test', $adapter->normalizePath('/test/'));
        $this->assertEquals('test/test', $adapter->normalizePath('/test/test/'));
        $this->assertEquals('test/test', $adapter->normalizePath('/test//test/'));
        $this->assertEquals('test/test', $adapter->normalizePath(['test', 'test']));

        # prefixedPath
        $this->assertEquals('testing/test/test.jpg', $adapter->prefixedPath('/test/', $file->name));

        # __create
        $sizes = getimagesize($fileInfo->getRealPath());
        $data = $adapter->__create('testing/test', $fileInfo, $file->name);
        $this->assertEquals($adapter->driver, $data['driver']);
        $this->assertEquals($file->name, $data['name']);
        $this->assertEquals($fileInfo->getFilename(), $data['original_name']);
        $this->assertEquals('testing/test', $data['path']);
        $this->assertEquals($fileInfo->getSize(), $data['size']);
        $this->assertEquals($fileInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);
    }

}

class BaseAdapterTestStub extends BaseAdapter
{

}