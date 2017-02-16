<?php

namespace Belt\Storage\Commands;

use Faker, Storage;
use Illuminate\Console\Command;

class FakerCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-storage:faker {--limit=5} {--c|category=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run faker commands';


    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $disk;

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk()
    {
        return $this->disk = $this->disk ?: Storage::disk('public');
    }

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $faker;

    /**
     * @return Faker\Generator
     */
    public function faker()
    {
        return $this->faker = $this->faker ?: Faker\Factory::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $disk = $this->disk();
        $faker = $this->faker();

        $limit = $this->option('limit');

        for ($i = 1; $i <= $limit; $i++) {
            $file = new \Illuminate\Http\File($faker->image(null, 640, 480, $this->option('category')));
            $disk->putFileAs('belt/database/images', $file, $file->getFilename());
            $this->info($file->getFilename());
        }

    }

}