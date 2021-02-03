<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    protected $integration;

    protected $path;

    protected $config;

    protected $prefix;

    protected $frontendNamespace;

    protected $backendNamespace;

    protected $apiNamespace;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct ($app)
    {
        parent::__construct ($app);

        $this->config = $this->app ['config']->get ('modules', []);

        $this->initRoute ();

    }

    protected function initRoute ()
    {
        $this->integration = $this->getModuleConfig ('integration', 'lightcms');
        $this->integration = Str::ucfirst (Str::lower ($this->integration));
        $this->namespace = $this->getModuleConfig ('namespace', 'App\\Modules');
        $this->path = rtrim ($this->getModuleConfig ('route.path', __DIR__ . '/../routes'), '/');
        $this->prefix =$this->getModuleConfig ('route.prefix', 'm');
        $this->frontendNamespace = $this->getModuleConfig ('route.frontend.namespace', 'Http\\Controllers\\Front');
        $this->backendNamespace = $this->getModuleConfig ('route.backend.namespace', 'Http\\Controllers\\Admin');
        $this->apiNamespace = $this->getModuleConfig ('route.api.namespace', 'Http\\Controllers\\Api');
    }

    protected function getModuleConfig ($key, $default)
    {
        return Arr::get ($this->config, $key, $default);
    }

    protected function getPath ($name = null)
    {
        return $this->path . '/' . (isset ($name) ? $name : 'web') . '.php';
    }



    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapMemberRoutes();
    }


    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes ()
    {
        if (app ()->has ('laravellocalization')) {
            $route = Route::middleware ('localeSessionRedirect', 'localizationRedirect', 'localeViewPath');
            $laravel_localization = app ('laravellocalization')->setLocale ();
            $route_file = $this->getPath ('admin');
            if (! empty ($laravel_localization)) {
                $route->prefix ($laravel_localization);
                $route->group (function () use ($route_file)
                {
                    Route::prefix ('goodcatch')
                        ->middleware ('web')
                        ->namespace ($this->namespace . '\\' . $this->integration. '\\' . $this->backendNamespace)
                        ->group ($route_file);
                });
            }
            else {
                Route::prefix ('goodcatch')
                    ->middleware ('web')
                    ->namespace ($this->namespace . '\\' . $this->integration. '\\' . $this->backendNamespace)
                    ->group ($route_file);
            }

        }

    }


    /**
     * Define the "member" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapMemberRoutes()
    {
        $route_file = $this->getPath ('member');
        if (file_exists ($route_file))
        {
            Route::prefix ('member')
                ->middleware ('web')
                ->namespace ($this->namespace . '\\' . $this->integration. '\\' . $this->frontendNamespace)
                ->group ($route_file);
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $route_file = $this->getPath ();
        if (file_exists ($route_file))
        {
            Route::middleware('web')
                ->namespace($this->namespace . '\\' . $this->integration. '\\' . $this->frontendNamespace)
                ->group($route_file);
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $route_file = $this->getPath ('api');
        if (file_exists ($route_file))
        {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace . '\\' . $this->integration. '\\' . $this->apiNamespace)
                ->group($route_file);
        }
    }
}
