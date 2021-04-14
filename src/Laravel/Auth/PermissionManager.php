<?php

namespace Goodcatch\Modules\Laravel\Auth;

use Goodcatch\Modules\Laravel\Contracts\Auth\ModulePermissionService;
use Goodcatch\Modules\Laravel\ServiceManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PermissionManager extends ServiceManager implements ModulePermissionService
{

    /**
     * @inheritDoc
     */
    public function createPermissionService ($alias)
    {
        return with($this->getConfig (
            'class',
            'Goodcatch\\Modules\\' . Str::ucfirst ($alias) . '\\Contracts\\Permission\\PermissionProvider'
        ), function ($class) use ($alias) {
            return new $class ($this->app, $alias);
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
     */
    public function createService ($alias)
    {
        return $this->createPermissionService ($alias);
    }
}