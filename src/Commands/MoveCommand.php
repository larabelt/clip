<?php

namespace Belt\Clip\Commands;

use Belt\Clip\Services\MoveService;
use Illuminate\Console\Command;

/**
 * Class MoveCommand
 * @package Belt\Clip\Commands
 */
class MoveCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-clip:move {source} {target} {--limit=100} {--ids=} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move images';


    /**
     * @var MoveService
     */
    public $service;

    /**
     * @return MoveService
     */
    public function service()
    {
        return $this->service = $this->service ?: new MoveService(['console' => $this]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = $this->service();

        $service->move($this->argument('source'), $this->argument('target'), [
            'ids' => $this->option('ids'),
            'limit' => $this->option('limit'),
            'path' => $this->option('path'),
        ]);
    }

}