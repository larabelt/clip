<?php

use Mockery as m;
use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Storage\File\File;
use Ohio\Storage\File\Adapters\BaseAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;

class BaseAdapterTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::__construct
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::config
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::randomFilename
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::normalizePath
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::relativeFilePath
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::relativeWebPath
     * @covers \Ohio\Storage\File\Adapters\BaseAdapter::__create
     */
    public function test()
    {
        $file = factory(File::class)->make();
        $file->name = 'test.jpg';
        $file->file_path = 'public/images/test.jpg';
        $file->web_path = 'images/test.jpg';

        $fileInfo = new UploadedFile(__DIR__ . '/../../test.jpg', 'test.jpg');

        # construct
        $adapter = new BaseAdapterTestStub('public');
        $this->assertNotNull($adapter->key);
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

        # relativeFilePath
        $this->assertEquals('test/test.jpg', $adapter->relativeFilePath('/test/', $file->name));

        # relativeWebPath
        $adapter->config['web_prefix'] = '';
        $this->assertEquals('test/test.jpg', $adapter->relativeWebPath('/test/', $file->name));
        $adapter->config['web_prefix'] = 'prefix';
        $this->assertEquals('prefix/test/test.jpg', $adapter->relativeWebPath('/test/', $file->name));

        # __create
        $sizes = getimagesize($fileInfo->getRealPath());
        $data = $adapter->__create('test', $fileInfo, $file->name);
        $this->assertEquals($adapter->key, $data['disk']);
        $this->assertEquals($file->name, $data['name']);
        $this->assertEquals($fileInfo->getFilename(), $data['original_name']);
        $this->assertEquals('test/test.jpg', $data['file_path']);
        $this->assertEquals('prefix/test/test.jpg', $data['web_path']);
        $this->assertEquals($fileInfo->getSize(), $data['size']);
        $this->assertEquals($fileInfo->getMimeType(), $data['mimetype']);
        $this->assertEquals($sizes[0], $data['width']);
        $this->assertEquals($sizes[1], $data['height']);
    }

}

class BaseAdapterTestStub extends BaseAdapter {

}