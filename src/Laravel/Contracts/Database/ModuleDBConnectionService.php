<?php

namespace Goodcatch\Modules\Laravel\Contracts\Database;

interface ModuleDBConnectionService
{

    /**
     * Create a provider by service driver.
     *
     * @param  string $driver service driver
     * @return DBConnectionProvider|mixed
     */
    public function createDBConnectionService ($driver);

}