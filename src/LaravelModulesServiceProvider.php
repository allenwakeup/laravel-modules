<?php

namespace Goodcatch\Modules;

use Goodcatch\Modules\Laravel\LaravelFileRepository;
use Goodcatch\Modules\Providers\ConsoleServiceProvider;
use Goodcatch\Modules\Providers\RouteServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider as ModulesServiceProvider;
use Nwidart\Modules\Contracts\RepositoryInterface;

class LaravelModulesServiceProvider extends ModulesServiceProvider
{
    public function register ()
    {
        parent::register ();

        $this->app->bind (RepositoryInterface::class, LaravelFileRepository::class);
    }


    /**
     * {@inheritdoc}
     */
    protected function registerServices ()
    {
        parent::registerServices ();
        // overwrite FileRepository
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository ($app, $path);
        });

    }

    protected function registerProviders ()
    {
        parent::registerProviders ();

        $this->app->register (RouteServiceProvider::class);
        $this->app->register (ConsoleServiceProvider::class);
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces ()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom ($configPath, 'modules');
        $this->publishes ([
            $configPath => config_path ('modules.php'),
        ], 'config');
    }
}
