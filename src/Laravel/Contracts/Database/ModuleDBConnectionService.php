<?php

namespace Goodcatch\Modules\Laravel\Contracts\Database;

interface ModuleDBConnectionService
{

    /**
     * Create a provider.
     *
     * @param  string  unique name
     * @return \Goodcatch\Modules\Laravel\Contracts\Database\DBConnectionProvider|mixed
     */
    public function createDBConnectionService ($alias);

}