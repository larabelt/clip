<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\BaseAdapter;
use Illuminate\Http\UploadedFile;

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
    }

}

class BaseAdapterTestStub extends BaseAdapter
{

}