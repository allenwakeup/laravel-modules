<?php

namespace Goodcatch\Modules\Laravel\Auth;

use Goodcatch\Modules\Laravel\Contracts\Auth\ModulePermissionService;
use Goodcatch\Modules\Laravel\ServiceManager;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Container\BindingResolutionException;

class PermissionManager extends ServiceManager implements ModulePermissionService
{

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function createPermissionService ($driver)
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
        return Arr::get ($this->config, "modules.service.permission.{$name}", $default);
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function createService ($driver)
    {
        return $this->createPermissionService ($driver);
    }
}