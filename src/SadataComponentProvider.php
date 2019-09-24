<?php

namespace Sada\SadataComponent;

use Illuminate\Support\ServiceProvider;
use Sada\SadataComponent\Middlewares\ReadNotification;
use Sada\SadataComponent\Middlewares\SuperAdmin;
use Sada\SadataComponent\Middlewares\UserGate;
use Sada\SadataComponent\Middlewares\UserPrivilege;

class SadataComponentProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app()->make('router')->aliasMiddleware('user_gate', UserGate::class);
        app()->make('router')->aliasMiddleware('user_privilege', UserPrivilege::class);
        app()->make('router')->aliasMiddleware('super_admin', SuperAdmin::class);
        app()->make('router')->aliasMiddleware('read_notif', ReadNotification::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViews();
        $this->publishAssets();
        $this->publishConfig();
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources' . DIRECTORY_SEPARATOR . 'views');
        $this->loadViewsFrom($viewsPath, 'sadata');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/sadata-component'),
        ], 'views');
    }

    private function publishAssets()
    {
        $this->publishes([
            $this->packagePath('resources/assets') => public_path('vendor/sadata'),
        ], 'assets');
    }

    private function publishConfig()
    {
        $configPath = $this->packagePath('config/sadata.php');

        $this->publishes([
            $configPath => config_path('sadata.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'sadata');
    }

    private function packagePath($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }
}
