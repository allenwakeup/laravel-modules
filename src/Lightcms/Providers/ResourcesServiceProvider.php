<?php

namespace Goodcatch\Modules\Lightcms\Providers;

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
                goodcatch_laravel_modules_path ('/resources/assets/lightcms/library') => $this->app->publicPath () . '/public/vendor',
                goodcatch_laravel_modules_path ('/resources/assets/lightcms/admin')         => $this->app->publicPath () . '/public/admin',
                goodcatch_laravel_modules_path ('/resources/views/lightcms/admin')          => $this->app->resourcePath ('views/admin'),

            ], 'goodcatch-modules-lightcms');
        }
    }

}
