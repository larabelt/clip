<?php

namespace Ohio\Storage\Base\Commands;

use Ohio\Storage\File\File;
use Storage;
use Ohio\Storage\File\Services\ResizeService;
use Illuminate\Console\Command;

class ResizeCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ohio-storage:resize {--limit=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'resize images';


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
     * @var ResizeService
     */
    public $service;

    /**
     * @return ResizeService
     */
    public function service()
    {
        return $this->service = $this->service ?: new ResizeService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = $this->option('limit');

        $service = $this->service();

        $files = File::take($limit)->get();

        foreach ($files as $file) {
            $this->info($file->name);
            $service->resize($file);
        }

    }

}