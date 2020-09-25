<?php

namespace Goodcatch\Modules;

use Nwidart\Modules\LaravelModulesServiceProvider as ModulesServiceProvider;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Exceptions\InvalidActivatorClass;
use Nwidart\Modules\Laravel\LaravelFileRepository;
use Nwidart\Modules\Contracts\ActivatorInterface;

class LaravelModulesServiceProvider extends ModulesServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository($app, $path);
        });
        $this->app->singleton(ActivatorInterface::class, function ($app) {
            $activator = $app['config']->get('modules.activator');
            $class = $app['config']->get('modules.activators.' . $activator)['class'];

            if ($class === null) {
                throw InvalidActivatorClass::missingConfig();
            }

            return new $class($app);
        });
        $this->app->alias(RepositoryInterface::class, 'modules');
    }
}
