<?php

namespace Goodcatch\Modules\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {
        $this->mapModulesRoutes ();
    }


    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapModulesRoutes ()
    {
        $path = $this->app ['config']->get ('modules.route.path') ?? __DIR__ . '/routes/modules.php';

        Route::prefix (LaravelLocalization::setLocale ())
            ->middleware ('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
            ->group (function () use ($path) {
                Route::prefix ('admin')
                    ->middleware ('web')
                    ->namespace (config ('modules.namespace', 'App\Modules'))
                    ->group ($path);
            });
    }
}
