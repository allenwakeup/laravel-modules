<?php

namespace Goodcatch\Modules\Laravel\Database;

use Goodcatch\Modules\Laravel\Contracts\Database\ModuleDBConnectionService;
use Goodcatch\Modules\Laravel\ServiceManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DBConnectionManager extends ServiceManager implements ModuleDBConnectionService
{

    /**
     * @inheritDoc
     */
    public function createDBConnectionService ($driver)
    {
        $class = $this->getConfig (
            "providers.$driver",
            'Goodcatch\\Modules\\' . Str::ucfirst ($driver) . '\\Contracts\\Database\\DBConnectionProvider'
        );
        return new $class ($this->app, $driver);
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
     */
    public function createService ($driver)
    {
        return $this->createDBConnectionService ($driver);
    }
}