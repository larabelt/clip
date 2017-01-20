<?php

namespace Ohio\Storage\Base;

use Validator;

use Ohio\Storage;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class OhioStorageServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/Http/routes.php';
        include __DIR__ . '/../file/Http/routes.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        // set view paths
        $this->loadViewsFrom(resource_path('ohio/storage/views'), 'ohio-storage');

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ohio-storage');

        // policies
        $this->registerPolicies($gate);

        // morphMap
        Relation::morphMap([
            'files' => Storage\File\File::class,
        ]);

        // commands
        $this->commands(Storage\Base\Commands\FakerCommand::class);
        $this->commands(Storage\Base\Commands\PublishCommand::class);
        $this->commands(Storage\Base\Commands\ResizeCommand::class);
    }

    /**
     * Register the application's policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function registerPolicies(GateContract $gate)
    {
//        $gate->before(function ($user, $ability) {
//            if ($user->hasRole('SUPER')) {
//                return true;
//            }
//        });
//
//        foreach ($this->policies as $key => $value) {
//            $gate->policy($key, $value);
//        }
    }

}