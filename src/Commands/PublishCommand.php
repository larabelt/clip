<?php

namespace Belt\Clip\Commands;

use Belt\Core\Commands\PublishCommand as Command;

/**
 * Class PublishCommand
 * @package Belt\Clip\Commands
 */
class PublishCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'belt-clip:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish assets for belt storage';

    /**
     * @var array
     */
    protected $dirs = [
        'vendor/larabelt/clip/config' => 'config/belt',
        'vendor/larabelt/clip/resources/js' => 'resources/belt/clip/js',
        'vendor/larabelt/clip/resources/sass' => 'resources/belt/clip/sass',
        'vendor/larabelt/clip/database/factories' => 'database/factories',
        'vendor/larabelt/clip/database/migrations' => 'database/migrations',
        'vendor/larabelt/clip/database/seeds' => 'database/seeds',
        'vendor/larabelt/clip/database/images' => 'storage/app/public/belt/database/images',
    ];

}