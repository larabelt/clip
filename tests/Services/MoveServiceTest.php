<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Attachment;
use Belt\Clip\Adapters\BaseAdapter;
use Belt\Clip\Adapters\LocalAdapter;
use Belt\Clip\Services\MoveService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MoveServiceTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();
        app()['config']->set('filesystems.disks.local', [
            'driver' => 'local',
            'root' => storage_path('app'),
        ]);
        app()['config']->set('belt.clip.drivers.foo', [
            'disk' => 'local',
            'adapter' => LocalAdapter::class,
            'prefix' => 'foo',
            'src' => ['root' => 'http://foo.local'],
            'secure' => ['root' => 'https://foo.local'],
        ]);
        app()['config']->set('belt.clip.drivers.bar', [
            'disk' => 'local',
            'adapter' => LocalAdapter::class,
            'prefix' => 'bar',
            'src' => ['root' => 'http://bar.local'],
            'secure' => ['root' => 'https://bar.local'],
        ]);
    }

    /**
     * @covers \Belt\Clip\Services\MoveService::__construct
     * @covers \Belt\Clip\Services\MoveService::adapter
     * @covers \Belt\Clip\Services\MoveService::log
     */
    public function test()
    {
        $service = new MoveService();

        # construct
        $this->assertInstanceOf(Attachment::class, $service->attachments);

        # adapter
        $this->assertInstanceOf(LocalAdapter::class, $service->adapter('foo'));

        # log
        $path = sprintf('storage/logs/moved-files/%s.log', date('Y-m-d'));
        $service->disk = m::mock(Filesystem::class);
        $service->disk->shouldReceive('append')->once()->with($path, 'test')->andReturnSelf();
        $service->log('test');
    }

    /**
     * @covers \Belt\Clip\Services\MoveService::move
     */
    public function testMove()
    {
        $service = new MoveService();

        $source_driver = 'foo';
        $target_driver = 'bar';
        $options = [
            'ids' => '1,2',
            'limit' => '100',
        ];

        Attachment::unguard();
        $attachments = new Collection();

        /* @var $attachment, $data Attachment */
        $data = factory(Attachment::class)->make([
            'driver' => 'foo',
            'path' => __DIR__ . '/../testing/test.jpg',
            'name' => 'test.jpg',
        ]);
        $data->setRelations([]);
        $attachment = m::mock(Attachment::class . '[getContentsAttribute,update,touch,toArray]');
        $attachment->shouldReceive('getContentsAttribute')->andReturn('contents');
        $attachment->shouldReceive('update')->andReturnSelf();
        $attachment->shouldReceive('touch')->andReturnSelf();
        $attachment->shouldReceive('toArray')->andReturn($data->toArray());
        $attachments->add($attachment);

        $data = factory(Attachment::class)->make([
            'driver' => 'foo',
            'path' => __DIR__ . '/../testing/test.jpg',
            'name' => 'test.jpg',
        ]);
        $data->setRelations([]);
        $attachment = m::mock(Attachment::class . '[getContentsAttribute,update,touch,toArray]');
        $attachment->shouldReceive('getContentsAttribute')->andReturn('contents');
        $attachment->shouldReceive('update')->andReturnSelf();
        $attachment->shouldReceive('touch')->andReturnSelf();
        $attachment->shouldReceive('toArray')->andReturn($data->toArray());
        $attachments->add($attachment);

        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->with('driver', $source_driver)->andReturnSelf();
        $qb->shouldReceive('orderBy')->with('updated_at')->andReturnSelf();
        $qb->shouldReceive('take')->with(100)->andReturnSelf();
        $qb->shouldReceive('whereIn')->with('id', [1, 2])->andReturnSelf();
        $qb->shouldReceive('get')->andReturn($attachments);
        $service->attachments = $qb;

        $service->disk = m::mock(Filesystem::class);
        $service->disk->shouldReceive('append')->withAnyArgs()->andReturnSelf();

        # good move
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('upload')->andReturn(['path' => 'new/path']);
        $service->adapters['foo'] = $adapter;
        $service->adapters['bar'] = $adapter;
        $service->move($source_driver, $target_driver, $options);

        # bad move
        $adapter = m::mock(BaseAdapter::class);
        $adapter->shouldReceive('upload')->andReturn([]);
        $service->adapters['foo'] = $adapter;
        $service->adapters['bar'] = $adapter;
        $service->move($source_driver, $target_driver, $options);
    }

}
