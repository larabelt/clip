<?php

namespace Belt\Storage\Commands;

use Belt\Storage\Services\ResizeService;
use Illuminate\Console\Command;

class ResizeCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-storage:resize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'resize images';


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
        $service = $this->service();

        $service->batch();
    }

}