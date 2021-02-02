<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Lightcms\Providers\AuthServiceProvider;
use Goodcatch\Modules\Lightcms\Providers\ResourcesServiceProvider;
use Illuminate\Support\ServiceProvider;

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
