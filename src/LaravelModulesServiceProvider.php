<?php

namespace Goodcatch\Modules;

use Nwidart\Modules\LaravelModulesServiceProvider as ModulesServiceProvider;
use Nwidart\Modules\Contracts\RepositoryInterface;

class LaravelModulesServiceProvider extends ModulesServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function registerServices ()
    {
        parent::registerServices ();

        // overwrite FileRepository
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository($app, $path);
        });

        // overwrite App Console Kernel
        $this->app->singleton ('goodcatch.kernel', function ($app) {
            $events = $app ['events'];
            return new Laravel\Console\Kernel ($app, $events);
        });

        $this->app->alias ('goodcatch.kernel', 'Illuminate\\Contracts\\Console\\Kernel');
    }
}
