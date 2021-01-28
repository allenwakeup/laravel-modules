<?php

namespace Goodcatch\Modules\Laravel\Contracts\Auth;

interface ModulePermissionService
{

    /**
     * Create a provider.
     *
     * @param  string  unique name
     * @return \Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider|mixed
     */
    public function createPermissionService ($alias);

}