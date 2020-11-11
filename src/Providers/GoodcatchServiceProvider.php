<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Laravel\Model\SysModule;
use Goodcatch\Modules\Laravel\Observers\SysModuleObserver;
use Illuminate\Support\ServiceProvider;

class GoodcatchServiceProvider extends ServiceProvider
{


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        SysModule::observe (SysModuleObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

}
