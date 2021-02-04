<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Lightcms\Providers\AuthServiceProvider;
use Goodcatch\Modules\Lightcms\Providers\ResourcesServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class LightcmsServiceProvider
 *
 * the main service provider that configured, so that laravel-modules requires.
 *
 * @package Goodcatch\Modules\Providers
 */
class LightcmsServiceProvider extends ServiceProvider
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

        $this->app->register (AuthServiceProvider::class);
        $this->app->register (ResourcesServiceProvider::class);
    }


}
