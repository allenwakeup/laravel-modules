<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    private $path;

    private $config;

    /**
     * defined modules route entries
     *
     * @var array $routes
     */
    private $routes;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct ($app)
    {
        parent::__construct ($app);

        $this->config = $this->app ['config'];

        $this->namespace = $this->config->get ('modules.namespace', 'App\\Modules');

        $this->path = rtrim ($this->config->get ('modules.route.path', __DIR__ . '/../routes'), '/');

        $this->routes = $this->config->get ('modules.route.entry', [
            'admin' => 'web'
        ]);

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {
        $this->mapRoutes ('goodcatch', 'Goodcatch\\Modules', 'web');

        foreach ($this->routes as $name => $middleware)
        {
            $this->mapRoutes ($name, $this->namespace, $middleware);
        }
    }

    protected function getRoutePath ($name)
    {
        return $this->path . '/' . (empty ($name) ? 'web' : $name) . '.php';
    }

    /**
     * Define the "modules" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapRoutes ($name, $namespace, $middleware = 'web')
    {

        if (app ()->has ('laravellocalization'))
        {
            $route = Route::middleware ('localeSessionRedirect', 'localizationRedirect', 'localeViewPath');

            $laravel_localization = app ('laravellocalization')->setLocale ();

            if (! empty ($laravel_localization))
            {
                $route->prefix ($laravel_localization);
            }

            $route->group (function () use ($name, $namespace, $middleware) {
                Route::prefix ($name)
                    ->middleware ($middleware)
                    ->namespace ($namespace)
                    ->group($this->getRoutePath ($name));
            });
        } else {
            Route::prefix ($name)
                ->middleware ($middleware)
                ->namespace ($namespace)
                ->group ($this->getRoutePath ($name));
        }
    }
}
