<?php

namespace Belt\Clip\Commands;

use Belt\Core\Commands\PublishCommand as Command;

class PublishCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-storage:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for belt storage';

    protected $dirs = [
        'vendor/larabelt/clip/config' => 'config/belt',
        'vendor/larabelt/clip/resources' => 'resources/belt/storage',
        'vendor/larabelt/clip/database/factories' => 'database/factories',
        'vendor/larabelt/clip/database/migrations' => 'database/migrations',
        'vendor/larabelt/clip/database/seeds' => 'database/seeds',
        'vendor/larabelt/clip/database/images' => 'storage/app/public/belt/database/images',
    ];

}