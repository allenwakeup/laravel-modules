<?php

namespace Goodcatch\Modules\Lightcms\Providers;

use Goodcatch\Modules\Lightcms\Jobs\FlushMenu;
use Illuminate\Support\ServiceProvider;

class JobsServiceProvider extends ServiceProvider
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

        $this->registerJobs ();
    }

    protected function registerJobs ()
    {
        $this->app->bind ('LightcmsFlushMenuJob', function ($app, $params) {
            return new FlushMenu ();
        });
    }

}
