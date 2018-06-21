<?php

namespace Belt\Clip;

use Belt;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class BeltClipServiceProvider
 * @package Belt\Clip
 */
class BeltClipServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Belt\Clip\Album::class => Belt\Clip\Policies\AlbumPolicy::class,
        Belt\Clip\Attachment::class => Belt\Clip\Policies\AttachmentPolicy::class,
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/../routes/admin.php';
        include __DIR__ . '/../routes/api.php';
        include __DIR__ . '/../routes/web.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate, Router $router)
    {

        // set backup view paths
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belt-clip');

        // policies
        $this->registerPolicies($gate);

        // morphMap
        Relation::morphMap([
            'albums' => Belt\Clip\Album::class,
            'attachments' => Belt\Clip\Attachment::class,
            'attachment_resizes' => Belt\Clip\Resize::class,
        ]);

        // route model binding
        $router->model('album', Belt\Clip\Album::class);
        $router->model('attachment', Belt\Clip\Attachment::class);
        $router->model('resize', Belt\Clip\Resize::class);

        // commands
        $this->commands(Belt\Clip\Commands\FakerCommand::class);
        $this->commands(Belt\Clip\Commands\MoveCommand::class);
        $this->commands(Belt\Clip\Commands\PublishCommand::class);
        $this->commands(Belt\Clip\Commands\ResizeCommand::class);

        # beltable values for global belt command
        $this->app['belt']->publish('belt-clip:publish');
        $this->app['belt']->seeders('BeltClipSeeder');

        # additional providers
        $this->app->register(Belt\Clip\Services\Cloudinary\CloudinaryServiceProvider::class);

        // access map for window config
        Belt\Core\Services\AccessService::put('*', 'albums');
        Belt\Core\Services\AccessService::put('*', 'attachments');
    }

    /**
     * Register the application's policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function registerPolicies(GateContract $gate)
    {
        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }
    }

}