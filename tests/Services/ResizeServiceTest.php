<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Clip\Behaviors\Clippable;
use Belt\Clip\Attachment;
use Belt\Clip\Resize;
use Belt\Clip\Adapters\BaseAdapter;
use Belt\Clip\Services\ResizeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;

class ResizeServiceTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();
        app()['config']->set('belt.clip.resize', [
            'foo' => 'bar',
            'local_driver' => 'default',
            'image_driver' => 'imagick',
            'models' => [
                ResizeServiceTestStub1::class,
                ResizeServiceTestStub2::class,
            ],
        ]);
    }

    /**
     * @covers \Belt\Clip\Services\ResizeService::__construct
     * @covers \Belt\Clip\Services\ResizeService::config
     * @covers \Belt\Clip\Services\ResizeService::adapter
     * @covers \Belt\Clip\Services\ResizeService::manager
     * @covers \Belt\Clip\Services\ResizeService::resizeRepo
     */
    public function test()
    {
        $service = new ResizeService(['super' => 'awesome']);

        # construct / config
        $this->assertNotEmpty($service->config);
        $this->assertEquals('bar', $service->config('foo'));
        $this->assertEquals('awesome', $service->config('super'));
        $this->assertEquals($service->config, $service->config());
        $this->assertEquals('default', $service->config('missing.item', 'default'));

        # adapter
        $this->assertInstanceOf(BaseAdapter::class, $service->adapter());

        # manager
        $this->assertInstanceOf(ImageManager::class, $service->manager());

        # resize repo
        $this->assertInstanceOf(Resize::class, $service->resizeRepo());
    }

    /**
     * @covers \Belt\Clip\Services\ResizeService::batch
     */
    public function testBatch()
    {
        $attachments1 = $this->attachments([1, 2, 3]);
        $attachments2 = $this->attachments([4, 5, 6]);
        $presets1 = ResizeServiceTestStub1::getResizePresets();
        $presets2 = ResizeServiceTestStub2::getResizePresets();

        app()['config']->set('belt.clip.resize.models', [
            ResizeServiceTestStub1::class => $presets1,
            ResizeServiceTestStub2::class => $presets2,
        ]);

        $service = m::mock(ResizeService::class . '[query,resize]');

        $service->attachments = m::mock(Attachment::class);
        $service->attachments->shouldReceive('find')->once()->with(1)->andReturn($attachments1->get(0));
        $service->attachments->shouldReceive('find')->once()->with(2)->andReturn($attachments1->get(1));
        $service->attachments->shouldReceive('find')->once()->with(3)->andReturn($attachments1->get(2));
        $service->attachments->shouldReceive('find')->once()->with(4)->andReturn($attachments2->get(0));
        $service->attachments->shouldReceive('find')->once()->with(5)->andReturn($attachments2->get(1));
        $service->attachments->shouldReceive('find')->once()->with(6)->andReturn($attachments2->get(2));

        $service->shouldReceive('query')->once()->with(ResizeServiceTestStub1::class, $presets1)->andReturn($attachments1);
        $service->shouldReceive('query')->once()->with(ResizeServiceTestStub2::class, $presets2)->andReturn($attachments2);

        $service->shouldReceive('resize')->once()->with($attachments1->get(0), $presets1);
        $service->shouldReceive('resize')->once()->with($attachments1->get(1), $presets1);
        $service->shouldReceive('resize')->once()->with($attachments1->get(2), $presets1);
        $service->shouldReceive('resize')->once()->with($attachments2->get(0), $presets2);
        $service->shouldReceive('resize')->once()->with($attachments2->get(1), $presets2);
        $service->shouldReceive('resize')->once()->with($attachments2->get(2), $presets2);

        $service->batch();
    }


    /**
     * @covers \Belt\Clip\Services\ResizeService::query
     */
    public function testQuery()
    {
        $attachments1 = $this->attachments([1, 2, 3]);
        $presets1 = ResizeServiceTestStub1::getResizePresets();

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->andReturnSelf();
        $qbMock->shouldReceive('take')->andReturnSelf();
        $qbMock->shouldReceive('join')->andReturnSelf();
        $qbMock->shouldReceive('leftJoin')->times(count($presets1))->andReturnSelf();
        $qbMock->shouldReceive('orWhereNull')->times(count($presets1))->andReturnSelf();
        $qbMock->shouldReceive('get')->andReturn($attachments1);

        $attachmentRepo = m::mock(Attachment::class);
        $attachmentRepo->shouldReceive('query')->andReturn($qbMock);

        $service = new ResizeService();
        $service->attachments = $attachmentRepo;

        $service->query(ResizeServiceTestStub1::class, $presets1);
    }

    /**
     * @covers \Belt\Clip\Services\ResizeService::resize
     */
    public function testResize()
    {
        $attachment = $this->attachments([1])->first();
        $attachment->resizes->push(factory(Resize::class)->make(['attachment' => $attachment, 'width' => 100, 'height' => 100]));

        $presets = ResizeServiceTestStub1::getResizePresets();

        $resizeRepo = m::mock(Resize::class);
        $resizeRepo->shouldReceive('unguard')->twice();
        $resizeRepo->shouldReceive('create')->twice();

        $manipulator = m::mock(ImageManager::class);
        $manipulator->shouldReceive('fit');
        $manipulator->shouldReceive('resize');
        $manipulator->shouldReceive('encode');

        $manager = m::mock(ImageManager::class);
        $manager->shouldReceive('make')->andReturn($manipulator);

        $service = new ResizeService();
        $service->resizeRepo = $resizeRepo;
        $service->resize($attachment, $presets);
    }


    public function attachments($ids = [])
    {
        Attachment::unguard();
        $attachments = new Collection();
        foreach ($ids as $id) {
            $attachment = factory(Attachment::class)->make();
            $attachment->id = $id;
            $attachment->resizes = new Collection();
            $attachments->push($attachment);
        }

        return $attachments;
    }

}

class ResizeServiceTestStub1 extends Model
{

    public static $presets = [
        [100, 100],
        [200, 200, 'resize'],
        [300, 300, 'resize'],
    ];

    use Belt\Core\Behaviors\HasSortableTrait;
    use Clippable;

}

class ResizeServiceTestStub2 extends Model
{

    public static $presets = [
        [300, 300],
        [500, 500],
    ];

    use Belt\Core\Behaviors\HasSortableTrait;
    use Clippable;
}
