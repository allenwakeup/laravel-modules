<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Lightcms\Providers\JobsServiceProvider;
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

        $this->app->register (ResourcesServiceProvider::class);
    }


}
