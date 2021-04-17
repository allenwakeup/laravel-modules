<?php

namespace Goodcatch\Modules\Laravel\Database;

use Goodcatch\Modules\Laravel\Contracts\Database\ModuleDBConnectionService;
use Goodcatch\Modules\Laravel\ServiceManager;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Container\BindingResolutionException;

class DBConnectionManager extends ServiceManager implements ModuleDBConnectionService
{

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function createDBConnectionService ($driver)
    {
        return with($this->getConfig (
            "providers.$driver",
            $this->getProviderClass($driver, 'Contracts\\Permission\\PermissionProvider')
        ), function ($class) use ($driver) {
            return new $class ($this->app, $driver);
        });
    }

    /**
     * Get the guard configuration.
     *
     * @param  string  $name
     * @param  string  $default
     * @return array
     */
    public function getConfig ($name, $default = null)
    {
        return Arr::get ($this->config, "modules.service.connection.{$name}", $default);
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function createService ($driver)
    {
        return $this->createDBConnectionService ($driver);
    }
}