<?php

namespace Ohio\Storage\Base\Commands;

use Ohio\Core\Base\Commands\PublishCommand as Command;

class PublishCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ohio-storage:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for ohio storage';

    protected $dirs = [
        'vendor/ohiocms/storage/config' => 'config/ohio',
        'vendor/ohiocms/storage/resources' => 'resources/ohio/storage',
        'vendor/ohiocms/storage/database/factories' => 'database/factories',
        'vendor/ohiocms/storage/database/migrations' => 'database/migrations',
        'vendor/ohiocms/storage/database/seeds' => 'database/seeds',
        'vendor/ohiocms/storage/database/images' => 'storage/app/public/ohio/database/images',
    ];

}