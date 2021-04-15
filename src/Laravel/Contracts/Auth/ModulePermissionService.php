<?php

namespace Goodcatch\Modules\Laravel\Contracts\Auth;

interface ModulePermissionService
{

    /**
     * Create a provider by service driver name.
     *
     * @param  string $driver service driver
     * @return PermissionProvider|mixed
     */
    public function createPermissionService ($driver);

}