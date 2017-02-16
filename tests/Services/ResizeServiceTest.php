<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Storage\Behaviors\Fileable;
use Belt\Storage\File;
use Belt\Storage\Resize;
use Belt\Storage\Adapters\BaseAdapter;
use Belt\Storage\Services\ResizeService;
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
        app()['config']->set('belt.storage.resize', [
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
     * @covers \Belt\Storage\Services\ResizeService::__construct
     * @covers \Belt\Storage\Services\ResizeService::config
     * @covers \Belt\Storage\Services\ResizeService::adapter
     * @covers \Belt\Storage\Services\ResizeService::manager
     * @covers \Belt\Storage\Services\ResizeService::resizeRepo
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
     * @covers \Belt\Storage\Services\ResizeService::batch
     */
    public function testBatch()
    {
        $files1 = $this->files([1, 2, 3]);
        $files2 = $this->files([4, 5, 6]);
        $presets1 = ResizeServiceTestStub1::getResizePresets();
        $presets2 = ResizeServiceTestStub2::getResizePresets();

        $service = m::mock(ResizeService::class . '[query,resize]');

        $service->files = m::mock(File::class);
        $service->files->shouldReceive('find')->once()->with(1)->andReturn($files1->get(0));
        $service->files->shouldReceive('find')->once()->with(2)->andReturn($files1->get(1));
        $service->files->shouldReceive('find')->once()->with(3)->andReturn($files1->get(2));
        $service->files->shouldReceive('find')->once()->with(4)->andReturn($files2->get(0));
        $service->files->shouldReceive('find')->once()->with(5)->andReturn($files2->get(1));
        $service->files->shouldReceive('find')->once()->with(6)->andReturn($files2->get(2));

        $service->shouldReceive('query')->once()->with(ResizeServiceTestStub1::class, $presets1)->andReturn($files1);
        $service->shouldReceive('query')->once()->with(ResizeServiceTestStub2::class, $presets2)->andReturn($files2);

        $service->shouldReceive('resize')->once()->with($files1->get(0), $presets1);
        $service->shouldReceive('resize')->once()->with($files1->get(1), $presets1);
        $service->shouldReceive('resize')->once()->with($files1->get(2), $presets1);
        $service->shouldReceive('resize')->once()->with($files2->get(0), $presets2);
        $service->shouldReceive('resize')->once()->with($files2->get(1), $presets2);
        $service->shouldReceive('resize')->once()->with($files2->get(2), $presets2);

        $service->batch();
    }


    /**
     * @covers \Belt\Storage\Services\ResizeService::query
     */
    public function testQuery()
    {
        $files1 = $this->files([1, 2, 3]);
        $presets1 = ResizeServiceTestStub1::getResizePresets();

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->andReturnSelf();
        $qbMock->shouldReceive('take')->andReturnSelf();
        $qbMock->shouldReceive('join')->andReturnSelf();
        $qbMock->shouldReceive('leftJoin')->times(count($presets1))->andReturnSelf();
        $qbMock->shouldReceive('orWhereNull')->times(count($presets1))->andReturnSelf();
        $qbMock->shouldReceive('get')->andReturn($files1);

        $fileRepo = m::mock(File::class);
        $fileRepo->shouldReceive('query')->andReturn($qbMock);

        $service = new ResizeService();
        $service->files = $fileRepo;

        $service->query(ResizeServiceTestStub1::class, $presets1);
    }

    /**
     * @covers \Belt\Storage\Services\ResizeService::resize
     */
    public function testResize()
    {
        $file = $this->files([1])->first();
        $file->resizes->push(factory(Resize::class)->make(['file' => $file, 'width' => 100, 'height' => 100]));

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
        $service->resize($file, $presets);
    }


    public function files($ids = [])
    {
        File::unguard();
        $files = new Collection();
        foreach ($ids as $id) {
            $file = factory(File::class)->make();
            $file->id = $id;
            $file->resizes = new Collection();
            $files->push($file);
        }

        return $files;
    }

}

class ResizeServiceTestStub1 extends Model
{

    public static $presets = [
        [100, 100],
        [200, 200, 'resize'],
        [300, 300, 'resize'],
    ];

    use Fileable;

}

class ResizeServiceTestStub2 extends Model
{

    public static $presets = [
        [300, 300],
        [500, 500],
    ];

    use Fileable;
}
