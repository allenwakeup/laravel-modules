<?php

namespace Goodcatch\Modules\Laravel\Database;

use Goodcatch\Modules\Laravel\Contracts\Database\ModuleDBConnectionService;
use Goodcatch\Modules\Laravel\Modules\AbsServiceManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DBConnectionManager extends AbsServiceManager implements ModuleDBConnectionService
{

    /**
     * @inheritDoc
     */
    public function createDBConnectionService ($alias)
    {
        $class = $this->getConfig (
            'class',
            'Goodcatch\\Modules\\' . Str::ucfirst ($alias) . '\\Contracts\\Database\\DBConnectionProvider'
        );
        return new $class ($this->app, $alias);
    }

    /**
     * Get the guard configuration.
     *
     * @param  string  $name
     * @return array
     */
    public function getConfig ($name, $default = null)
    {
        return Arr::get ($this->config, "modules.service.connection.{$name}", $default);
    }

}