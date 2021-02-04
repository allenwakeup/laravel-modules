<?php

namespace Goodcatch\Modules\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class ResourcesServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

        $this->registerViews ();
    }

    public function registerViews ()
    {
        if ($this->app->runningInConsole ()) {
            $this->publishes ([
                goodcatch_laravel_modules_path ('/resources/views/laravel/admin') => $this->app->resourcePath ('views/admin'),
            ], 'goodcatch-modules');
        }
    }

}
