<?php

namespace Sada\SadataComponent;

use Illuminate\Support\ServiceProvider;

class SadataComponentProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

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

    private function packagePath($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }
}
