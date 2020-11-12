<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Laravel\Model\Module;
use Goodcatch\Modules\Laravel\Observers\ModuleObserver;
use Illuminate\Support\ServiceProvider;

class GoodcatchServiceProvider extends ServiceProvider
{


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        Module::observe (ModuleObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

    }

}
