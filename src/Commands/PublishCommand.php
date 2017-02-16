<?php

namespace Belt\Storage\Commands;

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
        'vendor/larabelt/storage/config' => 'config/belt',
        'vendor/larabelt/storage/resources' => 'resources/belt/storage',
        'vendor/larabelt/storage/database/factories' => 'database/factories',
        'vendor/larabelt/storage/database/migrations' => 'database/migrations',
        'vendor/larabelt/storage/database/seeds' => 'database/seeds',
        'vendor/larabelt/storage/database/images' => 'storage/app/public/belt/database/images',
    ];

}